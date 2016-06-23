<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uploader extends Auth_Controller {

	/* Constructor */

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('jbimages','language'));

		// is_allowed is a helper function which is supposed to return False if upload operation is forbidden
		// [See jbimages/is_alllowed.php]

		if (is_allowed() === FALSE)
		{
			exit;
		}

		// User configured settings
		$this->config->load('uploader_settings', TRUE);

        $this->load->model('bloggers_model');
        $this->load->model('write_model');
        $this->load->library('form_builder');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

	/* Language set */

	private function _lang_set($lang)
	{
		// We accept any language set as lang_id in **_dlg.js
		// Therefore an error will occur if language file doesn't exist

		$this->config->set_item('language', $lang);
		$this->lang->load('jbstrings', $lang);
	}

	/* Default upload routine */

	public function upload ($lang='english')
	{

        if ($this->bloggers_model->check_logged()) {
            $user = $this->bloggers_model->get_user($this->session->userdata['username']);

                // Set language
            $this->_lang_set($lang);

            // Get configuartion data (we fill up 2 arrays - $config and $conf)

            $conf['img_path']			= $this->config->item('img_path',		'uploader_settings');
            $conf['allow_resize']		= $this->config->item('allow_resize',	'uploader_settings');

            $config['allowed_types']	= $this->config->item('allowed_types',	'uploader_settings');
            $config['max_size']			= $this->config->item('max_size',		'uploader_settings');
            $config['encrypt_name']		= $this->config->item('encrypt_name',	'uploader_settings');
            $config['overwrite']		= $this->config->item('overwrite',		'uploader_settings');
            $config['upload_path']		= $this->config->item('upload_path',	'uploader_settings').'/'.$user['folder'];

            if (!$conf['allow_resize'])
            {
                $config['max_width']	= $this->config->item('max_width',		'uploader_settings');
                $config['max_height']	= $this->config->item('max_height',		'uploader_settings');
            }
            else
            {
                $conf['max_width']		= $this->config->item('max_width',		'uploader_settings');
                $conf['max_height']		= $this->config->item('max_height',		'uploader_settings');

                if ($conf['max_width'] == 0 and $conf['max_height'] == 0)
                {
                    $conf['allow_resize'] = FALSE;
                }
            }

            // Load uploader
            $this->load->library('upload', $config);

            if ($this->upload->do_upload()) // Success
            {
                // General result data
                $result = $this->upload->data();

                // Shall we resize an image?
                if ($conf['allow_resize'] and $conf['max_width'] > 0 and $conf['max_height'] > 0 and (($result['image_width'] > $conf['max_width']) or ($result['image_height'] > $conf['max_height'])))
                {
                    // Resizing parameters
                    $resizeParams = array
                    (
                        'source_image'	=> $result['full_path'],
                        'new_image'		=> $result['full_path'],
                        'width'			=> $conf['max_width'],
                        'height'		=> $conf['max_height']
                    );

                    // Load resize library
                    $this->load->library('image_lib', $resizeParams);

                    // Do resize
                    $this->image_lib->resize();
                }

                // Add our stuff
                $result['result']		= "file_uploaded";
                $result['resultcode']	= 'ok';
                $result['file_name']	= $conf['img_path'] . '/'.$user['folder'].'/' . $result['file_name'];

                // Output to user
                $this->load->view('ajax_upload_result', $result);
            }
            else // Failure
            {

                // Compile data for output
                $result['result']		= $this->upload->display_errors(' ', ' ');
                $result['resultcode']	= 'failed';

                // Output to user
                $this->load->view('ajax_upload_result', $result);
            }
        } else {
            return 'You must be signed in';
        }
	}

	/* Blank Page (default source for iframe) */

	public function blank($lang='english')
	{
		$this->_lang_set($lang);
		$this->load->view('blank');
	}

	public function index($lang='english')
	{
		$this->blank($lang);
	}
}

/* End of file uploader.php */
/* Location: ./application/controllers/uploader.php */
