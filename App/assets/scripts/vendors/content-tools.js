/*! ContentTools v1.2.9 by Anthony Blackshaw <ant@getme.co.uk> (https://github.com/anthonyjb) */
(function () {
	var a, b;
	a = {}, a.Machine = function () {
		function a(a) {
			this.context = a, this._stateTransitions = {}, this._stateTransitionsAny = {}, this._defaultTransition = null, this._initialState = null, this._currentState = null
		}
		return a.prototype.addTransition = function (a, b, c, d) {
			return c || (c = b), this._stateTransitions[[a, b]] = [c, d]
		}, a.prototype.addTransitions = function (a, b, c, d) {
			var e, f, g, h;
			for (c || (c = b), h = [], f = 0, g = a.length; g > f; f++) e = a[f], h.push(this.addTransition(e, b, c, d));
			return h
		}, a.prototype.addTransitionAny = function (a, b, c) {
			return b || (b = a), this._stateTransitionsAny[a] = [b, c]
		}, a.prototype.setDefaultTransition = function (a, b) {
			return this._defaultTransition = [a, b]
		}, a.prototype.getTransition = function (a, b) {
			if (this._stateTransitions[[a, b]]) return this._stateTransitions[[a, b]];
			if (this._stateTransitionsAny[b]) return this._stateTransitionsAny[b];
			if (this._defaultTransition) return this._defaultTransition;
			throw new Error("Transition is undefined: (" + a + ", " + b + ")")
		}, a.prototype.getCurrentState = function () {
			return this._currentState
		}, a.prototype.setInitialState = function (a) {
			return this._initialState = a, this._currentState ? void 0 : this.reset()
		}, a.prototype.reset = function () {
			return this._currentState = this._initialState
		}, a.prototype.process = function (a) {
			var b;
			return b = this.getTransition(a, this._currentState), b[1] && b[1].call(this.context || (this.context = this), a), this._currentState = b[0]
		}, a
	}(), "undefined" != typeof window && (window.FSM = a), "undefined" != typeof module && module.exports && (b = module.exports = a)
}).call(this),
	function () {
		var a, b, c, d, e, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z, A, B = [].slice,
			C = [].indexOf || function (a) {
				for (var b = 0, c = this.length; c > b; b++)
					if (b in this && this[b] === a) return b;
				return -1
			};
		r = {}, "undefined" != typeof window && (window.HTMLString = r), "undefined" != typeof module && module.exports && (z = module.exports = r), r.String = function () {
			function a(a, b) {
				null == b && (b = !1), this._preserveWhitespace = b, a ? (null === r.String._parser && (r.String._parser = new A), this.characters = r.String._parser.parse(a, this._preserveWhitespace).characters) : this.characters = []
			}
			return a._parser = null, a.prototype.isWhitespace = function () {
				var a, b, c, d;
				for (d = this.characters, b = 0, c = d.length; c > b; b++)
					if (a = d[b], !a.isWhitespace()) return !1;
				return !0
			}, a.prototype.length = function () {
				return this.characters.length
			}, a.prototype.preserveWhitespace = function () {
				return this._preserveWhitespace
			}, a.prototype.capitalize = function () {
				var a, b;
				return b = this.copy(), b.length() && (a = b.characters[0]._c.toUpperCase(), b.characters[0]._c = a), b
			}, a.prototype.charAt = function (a) {
				return this.characters[a].copy()
			}, a.prototype.concat = function () {
				var a, b, c, d, e, f, g, h, i, j, k, l, m, n, o, p, q;
				for (g = 2 <= arguments.length ? B.call(arguments, 0, i = arguments.length - 1) : (i = 0, []), c = arguments[i++], "undefined" != typeof c && "boolean" != typeof c && (g.push(c), c = !0), e = this.copy(), j = 0, m = g.length; m > j; j++)
					if (f = g[j], 0 !== f.length) {
						if (h = f, "string" == typeof f && (h = new r.String(f, this._preserveWhitespace)), c && e.length())
							for (b = e.charAt(e.length() - 1), d = b.tags(), b.isTag() && d.shift(), "string" != typeof f && (h = h.copy()), p = h.characters, k = 0, n = p.length; n > k; k++) a = p[k], a.addTags.apply(a, d);
						for (q = h.characters, l = 0, o = q.length; o > l; l++) a = q[l], e.characters.push(a)
					}
				return e
			}, a.prototype.contains = function (a) {
				var b, c, d, e, f, g, h;
				if ("string" == typeof a) return this.text().indexOf(a) > -1;
				for (d = 0; d <= this.length() - a.length();) {
					for (c = !0, h = a.characters, e = f = 0, g = h.length; g > f; e = ++f)
						if (b = h[e], !b.eq(this.characters[e + d])) {
							c = !1;
							break
						}
					if (c) return !0;
					d++
				}
				return !1
			}, a.prototype.endsWith = function (a) {
				var b, c, d, e, f, g;
				if ("string" == typeof a) return "" === a || this.text().slice(-a.length) === a;
				for (c = this.characters.slice().reverse(), g = a.characters.slice().reverse(), d = e = 0, f = g.length; f > e; d = ++e)
					if (b = g[d], !b.eq(c[d])) return !1;
				return !0
			}, a.prototype.format = function () {
				var a, b, c, d, e, f, g;
				for (b = arguments[0], f = arguments[1], e = 3 <= arguments.length ? B.call(arguments, 2) : [], 0 > f && (f = this.length() + f + 1), 0 > b && (b = this.length() + b), d = this.copy(), c = g = b; f >= b ? f > g : g > f; c = f >= b ? ++g : --g) a = d.characters[c], a.addTags.apply(a, e);
				return d
			}, a.prototype.hasTags = function () {
				var a, b, c, d, e, f, g, h;
				for (d = 2 <= arguments.length ? B.call(arguments, 0, e = arguments.length - 1) : (e = 0, []), c = arguments[e++], "undefined" != typeof c && "boolean" != typeof c && (d.push(c), c = !1), b = !1, h = this.characters, f = 0, g = h.length; g > f; f++)
					if (a = h[f], a.hasTags.apply(a, d)) b = !0;
					else if (c) return !1;
				return b
			}, a.prototype.html = function () {
				var a, b, c, d, e, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w;
				for (e = "", h = [], f = [], c = [], t = this.characters, j = 0, n = t.length; n > j; j++) {
					for (a = t[j], c = [], u = h.slice().reverse(), k = 0, o = u.length; o > k; k++)
						if (g = u[k], c.push(g), !a.hasTags(g)) {
							for (l = 0, p = c.length; p > l; l++) b = c[l], e += b.tail(), h.pop(), f.pop();
							c = []
						}
					for (v = a._tags, m = 0, q = v.length; q > m; m++) i = v[m], -1 === f.indexOf(i.head()) && (i.selfClosing() || (d = i.head(), e += d, h.push(i), f.push(d)));
					a._tags.length > 0 && a._tags[0].selfClosing() && (e += a._tags[0].head()), e += a.c()
				}
				for (w = h.reverse(), s = 0, r = w.length; r > s; s++) i = w[s], e += i.tail();
				return e
			}, a.prototype.indexOf = function (a, b) {
				var c, d, e, f, g, h;
				if (null == b && (b = 0), 0 > b && (b = 0), "string" == typeof a) return this.text().indexOf(a, b);
				for (; b <= this.length() - a.length();) {
					for (d = !0, h = a.characters, e = f = 0, g = h.length; g > f; e = ++f)
						if (c = h[e], !c.eq(this.characters[e + b])) {
							d = !1;
							break
						}
					if (d) return b;
					b++
				}
				return -1
			}, a.prototype.insert = function (a, b, c) {
				var d, e, f, g, h, i, j, k, l, m, n, o, p, q, s, t;
				if (null == c && (c = !0), e = this.slice(0, a), j = this.slice(a), 0 > a && (a = this.length() + a), h = b, "string" == typeof b && (h = new r.String(b, this._preserveWhitespace)), c && a > 0)
					for (f = this.charAt(a - 1), g = f.tags(), f.isTag() && g.shift(), "string" != typeof b && (h = h.copy()), q = h.characters, k = 0, n = q.length; n > k; k++) d = q[k], d.addTags.apply(d, g);
				for (i = e, s = h.characters, l = 0, o = s.length; o > l; l++) d = s[l], i.characters.push(d);
				for (t = j.characters, m = 0, p = t.length; p > m; m++) d = t[m], i.characters.push(d);
				return i
			}, a.prototype.lastIndexOf = function (a, b) {
				var c, d, e, f, g, h, i, j, k;
				if (null == b && (b = 0), 0 > b && (b = 0), d = this.characters.slice(b).reverse(), b = 0, "string" == typeof a) {
					if (!this.contains(a)) return -1;
					for (a = a.split("").reverse(); b <= d.length - a.length;) {
						for (e = !0, g = 0, f = h = 0, j = a.length; j > h; f = ++h)
							if (c = a[f], d[f + b].isTag() && (g += 1), c !== d[g + f + b].c()) {
								e = !1;
								break
							}
						if (e) return b;
						b++
					}
					return -1
				}
				for (a = a.characters.slice().reverse(); b <= d.length - a.length;) {
					for (e = !0, f = i = 0, k = a.length; k > i; f = ++i)
						if (c = a[f], !c.eq(d[f + b])) {
							e = !1;
							break
						}
					if (e) return b;
					b++
				}
				return -1
			}, a.prototype.optimize = function () {
				var a, b, c, d, e, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z, A, B, C, D, E, F, G, H, I, J;
				for (i = [], g = [], e = null, D = this.characters.slice().reverse(), p = 0, t = D.length; t > p; p++) {
					for (a = D[p], a._runLengthMap = {}, a._runLengthMapSize = 0, c = [], E = i.slice().reverse(), q = 0, u = E.length; u > q; q++)
						if (h = E[q], c.push(h), !a.hasTags(h)) {
							for (r = 0, v = c.length; v > r; r++) b = c[r], i.pop(), g.pop();
							c = []
						}
					for (F = a._tags, s = 0, w = F.length; w > s; s++) o = F[s], -1 === g.indexOf(o.head()) && (o.selfClosing() || (i.push(o), g.push(o.head())));
					for (A = 0, x = i.length; x > A; A++) o = i[A], d = o.head(), e ? (a._runLengthMap[d] || (a._runLengthMap[d] = [o, 0]), m = 0, e._runLengthMap[d] && (m = e._runLengthMap[d][1]), a._runLengthMap[d][1] = m + 1) : a._runLengthMap[d] = [o, 1];
					e = a
				}
				for (k = function (a, b) {
						return b[1] - a[1]
					}, G = this.characters, J = [], B = 0, y = G.length; y > B; B++)
					if (a = G[B], f = a._tags.length, !(f > 0 && a._tags[0].selfClosing() && 3 > f || 2 > f)) {
						l = [], H = a._runLengthMap;
						for (o in H) j = H[o], l.push(j);
						for (l.sort(k), I = a._tags.slice(), C = 0, z = I.length; z > C; C++) o = I[C], o.selfClosing() || a.removeTags(o);
						J.push(a.addTags.apply(a, function () {
							var a, b, c;
							for (c = [], b = 0, a = l.length; a > b; b++) n = l[b], c.push(n[0]);
							return c
						}()))
					}
				return J
			}, a.prototype.slice = function (a, b) {
				var c, d;
				return d = new r.String("", this._preserveWhitespace), d.characters = function () {
					var d, e, f, g;
					for (f = this.characters.slice(a, b), g = [], d = 0, e = f.length; e > d; d++) c = f[d], g.push(c.copy());
					return g
				}.call(this), d
			}, a.prototype.split = function (a, b) {
				var c, d, e, f, g, h, i, j;
				for (null == a && (a = ""), null == b && (b = 0), g = 0, c = 0, f = [0];;) {
					if (b > 0 && c > b) break;
					if (e = this.indexOf(a, g), -1 === e || e === this.length() - 1) break;
					f.push(e), g = e + 1
				}
				for (f.push(this.length()), h = [], d = i = 0, j = f.length - 2; j >= 0 ? j >= i : i >= j; d = j >= 0 ? ++i : --i) h.push(this.slice(f[d], f[d + 1]));
				return h
			}, a.prototype.startsWith = function (a) {
				var b, c, d, e, f;
				if ("string" == typeof a) return this.text().slice(0, a.length) === a;
				for (f = a.characters, c = d = 0, e = f.length; e > d; c = ++d)
					if (b = f[c], !b.eq(this.characters[c])) return !1;
				return !0
			}, a.prototype.substr = function (a, b) {
				return 0 >= b ? new r.String("", this._preserveWhitespace) : (0 > a && (a = this.length() + a), void 0 === b && (b = this.length() - a), this.slice(a, a + b))
			}, a.prototype.substring = function (a, b) {
				return void 0 === b && (b = this.length()), this.slice(a, b)
			}, a.prototype.text = function () {
				var a, b, c, d, e;
				for (b = "", e = this.characters, c = 0, d = e.length; d > c; c++) a = e[c], a.isTag() ? a.isTag("br") && (b += "\n") : b += ("&nbsp;" !== a.c(), a.c());
				return this.constructor.decode(b)
			}, a.prototype.toLowerCase = function () {
				var a, b, c, d, e;
				for (b = this.copy(), e = b.characters, c = 0, d = e.length; d > c; c++) a = e[c], 1 === a._c.length && (a._c = a._c.toLowerCase());
				return b
			}, a.prototype.toUpperCase = function () {
				var a, b, c, d, e;
				for (b = this.copy(), e = b.characters, c = 0, d = e.length; d > c; c++) a = e[c], 1 === a._c.length && (a._c = a._c.toUpperCase());
				return b
			}, a.prototype.trim = function () {
				var a, b, c, d, e, f, g, h, i, j;
				for (i = this.characters, b = e = 0, g = i.length; g > e && (a = i[b], a.isWhitespace()); b = ++e);
				for (j = this.characters.slice().reverse(), d = f = 0, h = j.length; h > f && (a = j[d], a.isWhitespace()); d = ++f);
				return d = this.length() - d - 1, c = new r.String("", this._preserveWhitespace), c.characters = function () {
					var c, e, f, g;
					for (f = this.characters.slice(b, +d + 1 || 9e9), g = [], c = 0, e = f.length; e > c; c++) a = f[c], g.push(a.copy());
					return g
				}.call(this), c
			}, a.prototype.trimLeft = function () {
				var a, b, c, d, e, f, g;
				for (d = this.length() - 1, g = this.characters, b = e = 0, f = g.length; f > e && (a = g[b], a.isWhitespace()); b = ++e);
				return c = new r.String("", this._preserveWhitespace), c.characters = function () {
					var c, e, f, g;
					for (f = this.characters.slice(b, +d + 1 || 9e9), g = [], c = 0, e = f.length; e > c; c++) a = f[c], g.push(a.copy());
					return g
				}.call(this), c
			}, a.prototype.trimRight = function () {
				var a, b, c, d, e, f, g;
				for (b = 0, g = this.characters.slice().reverse(), d = e = 0, f = g.length; f > e && (a = g[d], a.isWhitespace()); d = ++e);
				return d = this.length() - d - 1, c = new r.String("", this._preserveWhitespace), c.characters = function () {
					var c, e, f, g;
					for (f = this.characters.slice(b, +d + 1 || 9e9), g = [], c = 0, e = f.length; e > c; c++) a = f[c], g.push(a.copy());
					return g
				}.call(this), c
			}, a.prototype.unformat = function () {
				var a, b, c, d, e, f, g;
				for (b = arguments[0], f = arguments[1], e = 3 <= arguments.length ? B.call(arguments, 2) : [], 0 > f && (f = this.length() + f + 1), 0 > b && (b = this.length() + b), d = this.copy(), c = g = b; f >= b ? f > g : g > f; c = f >= b ? ++g : --g) a = d.characters[c], a.removeTags.apply(a, e);
				return d
			}, a.prototype.copy = function () {
				var a, b;
				return b = new r.String("", this._preserveWhitespace), b.characters = function () {
					var b, c, d, e;
					for (d = this.characters, e = [], b = 0, c = d.length; c > b; b++) a = d[b], e.push(a.copy());
					return e
				}.call(this), b
			}, a.encode = function (a) {
				var b;
				return b = document.createElement("textarea"), b.textContent = a, b.innerHTML
			}, a.decode = function (a) {
				var b;
				return b = document.createElement("textarea"), b.innerHTML = a, b.textContent
			}, a
		}(), a = "AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz-_$".split(""), b = a.concat("1234567890".split("")), h = b.concat([":"]), q = b.concat(["#"]), u = b.concat([":"]), n = 1, p = 2, t = 3, s = 4, o = 5, x = 6, v = 7, y = 8, w = 9, j = 10, g = 11, i = 12, c = 13, m = 14, k = 15, l = 16, e = 17, f = 18, d = 19, A = function () {
			function z() {
				this.fsm = new FSM.Machine(this), this.fsm.setInitialState(n), this.fsm.addTransitionAny(n, null, function (a) {
					return this._pushChar(a)
				}), this.fsm.addTransition("<", n, t), this.fsm.addTransition("&", n, p), this.fsm.addTransitions(q, p, null, function (a) {
					return this.entity += a
				}), this.fsm.addTransition(";", p, n, function () {
					return this._pushChar("&" + this.entity + ";"), this.entity = ""
				}), this.fsm.addTransitions([" ", "\n"], t), this.fsm.addTransitions(a, t, s, function () {
					return this._back()
				}), this.fsm.addTransition("/", t, o), this.fsm.addTransitions([" ", "\n"], s), this.fsm.addTransitions(a, s, x, function () {
					return this._back()
				}), this.fsm.addTransitions([" ", "\n"], o), this.fsm.addTransitions(a, o, v, function () {
					return this._back()
				}), this.fsm.addTransitions(u, x, null, function (a) {
					return this.tagName += a
				}), this.fsm.addTransitions([" ", "\n"], x, j), this.fsm.addTransition("/", x, y, function () {
					return this.selfClosing = !0
				}), this.fsm.addTransition(">", x, n, function () {
					return this._pushTag()
				}), this.fsm.addTransitions([" ", "\n"], y), this.fsm.addTransition(">", y, n, function () {
					return this._pushTag()
				}), this.fsm.addTransitions([" ", "\n"], j), this.fsm.addTransition("/", j, y, function () {
					return this.selfClosing = !0
				}), this.fsm.addTransition(">", j, n, function () {
					return this._pushTag()
				}), this.fsm.addTransitions(a, j, g, function () {
					return this._back()
				}), this.fsm.addTransitions(u, v, null, function (a) {
					return this.tagName += a
				}), this.fsm.addTransitions([" ", "\n"], v, w), this.fsm.addTransition(">", v, n, function () {
					return this._popTag()
				}), this.fsm.addTransitions([" ", "\n"], w), this.fsm.addTransition(">", w, n, function () {
					return this._popTag()
				}), this.fsm.addTransitions(h, g, null, function (a) {
					return this.attributeName += a
				}), this.fsm.addTransitions([" ", "\n"], g, i), this.fsm.addTransition("=", g, c), this.fsm.addTransitions([" ", "\n"], i), this.fsm.addTransition("=", i, c), this.fsm.addTransitions(">", g, j, function () {
					return this._pushAttribute(), this._back()
				}), this.fsm.addTransitionAny(i, j, function () {
					return this._pushAttribute(), this._back()
				}), this.fsm.addTransitions([" ", "\n"], c), this.fsm.addTransition("'", c, m), this.fsm.addTransition('"', c, k), this.fsm.addTransitions(b.concat(["&"], c, l, function () {
					return this._back()
				})), this.fsm.addTransition(" ", l, j, function () {
					return this._pushAttribute()
				}), this.fsm.addTransitions(["/", ">"], l, j, function () {
					return this._back(), this._pushAttribute()
				}), this.fsm.addTransition("&", l, e), this.fsm.addTransitionAny(l, null, function (a) {
					return this.attributeValue += a
				}), this.fsm.addTransition("'", m, j, function () {
					return this._pushAttribute()
				}), this.fsm.addTransition("&", m, f), this.fsm.addTransitionAny(m, null, function (a) {
					return this.attributeValue += a
				}), this.fsm.addTransition('"', k, j, function () {
					return this._pushAttribute()
				}), this.fsm.addTransition("&", k, d), this.fsm.addTransitionAny(k, null, function (a) {
					return this.attributeValue += a
				}), this.fsm.addTransitions(q, e, null, function (a) {
					return this.entity += a
				}), this.fsm.addTransitions(q, f, function (a) {
					return this.entity += a
				}), this.fsm.addTransitions(q, d, null, function (a) {
					return this.entity += a
				}), this.fsm.addTransition(";", e, l, function () {
					return this.attributeValue += "&" + this.entity + ";", this.entity = ""
				}), this.fsm.addTransition(";", f, m, function () {
					return this.attributeValue += "&" + this.entity + ";", this.entity = ""
				}), this.fsm.addTransition(";", d, k, function () {
					return this.attributeValue += "&" + this.entity + ";", this.entity = ""
				})
			}
			return z.prototype._back = function () {
				return this.head--
			}, z.prototype._pushAttribute = function () {
				return this.attributes[this.attributeName] = this.attributeValue, this.attributeName = "", this.attributeValue = ""
			}, z.prototype._pushChar = function (a) {
				var b, c;
				return b = new r.Character(a, this.tags), this._preserveWhitespace ? void this.string.characters.push(b) : !this.string.length() || b.isTag() || b.isEntity() || !b.isWhitespace() || (c = this.string.characters[this.string.length() - 1], !c.isWhitespace() || c.isTag() || c.isEntity()) ? this.string.characters.push(b) : void 0
			}, z.prototype._pushTag = function () {
				var a, b;
				return a = new r.Tag(this.tagName, this.attributes), this.tags.push(a), a.selfClosing() && (this._pushChar(""), this.tags.pop(), !this.selfClosed && (b = this.tagName, C.call(r.Tag.SELF_CLOSING, b) >= 0) && this.fsm.reset()), this.tagName = "", this.selfClosed = !1, this.attributes = {}
			}, z.prototype._popTag = function () {
				for (var a, b;;)
					if (b = this.tags.pop(), this.string.length() && (a = this.string.characters[this.string.length() - 1], a.isTag() || a.isEntity() || !a.isWhitespace() || a.removeTags(b)), b.name() === this.tagName.toLowerCase()) break;
				return this.tagName = ""
			}, z.prototype.parse = function (a, b) {
				var c, d;
				for (this._preserveWhitespace = b, this.reset(), a = this.preprocess(a), this.fsm.parser = this; this.head < a.length;) {
					c = a[this.head];
					try {
						this.fsm.process(c)
					} catch (e) {
						throw d = e, new Error("Error at char " + this.head + " >> " + d)
					}
					this.head++
				}
				return this.string
			}, z.prototype.preprocess = function (a) {
				return a = a.replace(/\r\n/g, "\n").replace(/\r/g, "\n"), a = a.replace(/<!--[\s\S]*?-->/g, ""), this._preserveWhitespace || (a = a.replace(/\s+/g, " ")), a
			}, z.prototype.reset = function () {
				return this.fsm.reset(), this.head = 0, this.string = new r.String, this.entity = "", this.tags = [], this.tagName = "", this.selfClosing = !1, this.attributes = {}, this.attributeName = "", this.attributeValue = ""
			}, z
		}(), r.Tag = function () {
			function a(a, b) {
				var c, d;
				this._name = a.toLowerCase(), this._selfClosing = r.Tag.SELF_CLOSING[this._name] === !0, this._head = null, this._attributes = {};
				for (c in b) d = b[c], this._attributes[c] = d
			}
			return a.SELF_CLOSING = {
				area: !0,
				base: !0,
				br: !0,
				hr: !0,
				img: !0,
				input: !0,
				"link meta": !0,
				wbr: !0
			}, a.prototype.head = function () {
				var a, b, c, d;
				if (!this._head) {
					a = [], d = this._attributes;
					for (b in d) c = d[b], a.push(c ? "" + b + '="' + c + '"' : "" + b);
					a.sort(), a.unshift(this._name), this._head = "<" + a.join(" ") + ">"
				}
				return this._head
			}, a.prototype.name = function () {
				return this._name
			}, a.prototype.selfClosing = function () {
				return this._selfClosing
			}, a.prototype.tail = function () {
				return this._selfClosing ? "" : "</" + this._name + ">"
			}, a.prototype.attr = function (a, b) {
				return void 0 === b ? this._attributes[a] : (this._attributes[a] = b, this._head = null)
			}, a.prototype.removeAttr = function (a) {
				return void 0 !== this._attributes[a] ? delete this._attributes[a] : void 0
			}, a.prototype.copy = function () {
				return new r.Tag(this._name, this._attributes)
			}, a
		}(), r.Character = function () {
			function a(a, b) {
				this._c = a, a.length > 1 && (this._c = a.toLowerCase()), this._tags = [], this.addTags.apply(this, b)
			}
			return a.prototype.c = function () {
				return this._c
			}, a.prototype.isEntity = function () {
				return this._c.length > 1
			}, a.prototype.isTag = function (a) {
				return 0 !== this._tags.length && this._tags[0].selfClosing() ? a && this._tags[0].name() !== a ? !1 : !0 : !1
			}, a.prototype.isWhitespace = function () {
				var a;
				return " " === (a = this._c) || "\n" === a || "&nbsp;" === a || this.isTag("br")
			}, a.prototype.tags = function () {
				var a;
				return function () {
					var b, c, d, e;
					for (d = this._tags, e = [], b = 0, c = d.length; c > b; b++) a = d[b], e.push(a.copy());
					return e
				}.call(this)
			}, a.prototype.addTags = function () {
				var a, b, c, d, e;
				for (b = 1 <= arguments.length ? B.call(arguments, 0) : [], e = [], c = 0, d = b.length; d > c; c++) a = b[c], Array.isArray(a) || (a.selfClosing() ? this.isTag() || this._tags.unshift(a.copy()) : e.push(this._tags.push(a.copy())));
				return e
			}, a.prototype.eq = function (a) {
				var b, c, d, e, f, g, h, i;
				if (this.c() !== a.c()) return !1;
				if (this._tags.length !== a._tags.length) return !1;
				for (c = {}, h = this._tags, d = 0, f = h.length; f > d; d++) b = h[d], c[b.head()] = !0;
				for (i = a._tags, e = 0, g = i.length; g > e; e++)
					if (b = i[e], !c[b.head()]) return !1;
				return !0
			}, a.prototype.hasTags = function () {
				var a, b, c, d, e, f, g, h, i;
				for (d = 1 <= arguments.length ? B.call(arguments, 0) : [], c = {}, b = {}, i = this._tags, e = 0, g = i.length; g > e; e++) a = i[e], c[a.name()] = !0, b[a.head()] = !0;
				for (f = 0, h = d.length; h > f; f++)
					if (a = d[f], "string" == typeof a) {
						if (void 0 === c[a]) return !1
					} else if (void 0 === b[a.head()]) return !1;
				return !0
			}, a.prototype.removeTags = function () {
				var a, b, c, d, e, f, g;
				if (e = 1 <= arguments.length ? B.call(arguments, 0) : [], 0 === e.length) return void(this._tags = []);
				for (b = {}, a = {}, f = 0, g = e.length; g > f; f++) d = e[f], "string" == typeof d ? b[d] = d : a[d.head()] = d;
				return c = [], this._tags = this._tags.filter(function (c) {
					return a[c.head()] || b[c.name()] ? void 0 : c
				})
			}, a.prototype.copy = function () {
				var a;
				return new r.Character(this._c, function () {
					var b, c, d, e;
					for (d = this._tags, e = [], b = 0, c = d.length; c > b; b++) a = d[b], e.push(a.copy());
					return e
				}.call(this))
			}, a
		}()
	}.call(this),
	function () {
		var a, b, c, d, e, f, g, h = [].indexOf || function (a) {
			for (var b = 0, c = this.length; c > b; b++)
				if (b in this && this[b] === a) return b;
			return -1
		};
		a = {}, a.Range = function () {
			function c(a, b) {
				this.set(a, b)
			}
			return c.prototype.isCollapsed = function () {
				return this._from === this._to
			}, c.prototype.span = function () {
				return this._to - this._from
			}, c.prototype.collapse = function () {
				return this._to = this._from
			}, c.prototype.eq = function (a) {
				return this.get()[0] === a.get()[0] && this.get()[1] === a.get()[1]
			}, c.prototype.get = function () {
				return [this._from, this._to]
			}, c.prototype.select = function (b) {
				var c, d, f, g, h, i, j, k, l;
				return a.Range.unselectAll(), c = document.createRange(), k = e(b, this._from), h = k[0], j = k[1], l = e(b, this._to), d = l[0], g = l[1], i = h.length || 0, f = d.length || 0, c.setStart(h, Math.min(j, i)), c.setEnd(d, Math.min(g, f)), window.getSelection().addRange(c)
			}, c.prototype.set = function (a, b) {
				return a = Math.max(0, a), b = Math.max(0, b), this._from = Math.min(a, b), this._to = Math.max(a, b)
			}, c.prepareElement = function (a) {
				var c, d, e, f, g, h;
				for (e = a.querySelectorAll(b.join(", ")), h = [], c = f = 0, g = e.length; g > f; c = ++f) d = e[c], d.parentNode.insertBefore(document.createTextNode(""), d), h.push(c < e.length - 1 ? d.parentNode.insertBefore(document.createTextNode(""), d.nextSibling) : void 0);
				return h
			}, c.query = function (b) {
				var c, e, h, i, j, k, l;
				i = new a.Range(0, 0);
				try {
					c = window.getSelection().getRangeAt(0)
				} catch (m) {
					return i
				}
				return null === b.firstChild && null === b.lastChild ? i : d(c.startContainer, b) && d(c.endContainer, b) ? (l = f(b, c), j = l[0], k = l[1], e = l[2], h = l[3], i.set(g(b, j) + k, g(b, e) + h), i) : i
			}, c.rect = function () {
				var a, b, c;
				try {
					a = window.getSelection().getRangeAt(0)
				} catch (d) {
					return null
				}
				return a.collapsed ? (b = document.createElement("span"), a.insertNode(b), c = b.getBoundingClientRect(), b.parentNode.removeChild(b), c) : a.getBoundingClientRect()
			}, c.unselectAll = function () {
				return window.getSelection() ? window.getSelection().removeAllRanges() : void 0
			}, c
		}(), b = ["br", "img", "input"], d = function (a, b) {
			for (; a;) {
				if (a === b) return !0;
				a = a.parentNode
			}
			return !1
		}, e = function (a, c) {
			var d, e, f, g, i;
			if (0 === a.childNodes.length) return [a, c];
			for (d = null, e = c, f = function () {
					var b, c, d, e;
					for (d = a.childNodes, e = [], b = 0, c = d.length; c > b; b++) g = d[b], e.push(g);
					return e
				}(); f.length > 0;) switch (d = f.shift(), d.nodeType) {
			case Node.TEXT_NODE:
				if (d.textContent.length >= e) return [d, e];
				e -= d.textContent.length;
				break;
			case Node.ELEMENT_NODE:
				if (i = d.nodeName.toLowerCase(), h.call(b, i) >= 0) {
					if (0 === e) return [d, 0];
					e = Math.max(0, e - 1)
				} else d.childNodes && Array.prototype.unshift.apply(f, function () {
					var a, b, c, e;
					for (c = d.childNodes, e = [], a = 0, b = c.length; b > a; a++) g = c[a], e.push(g);
					return e
				}())
			}
			return [d, e]
		}, g = function (a, c) {
			var d, e, f, g, i, j;
			if (0 === a.childNodes.length) return 0;
			for (f = 0, d = function () {
					var b, c, d, f;
					for (d = a.childNodes, f = [], b = 0, c = d.length; c > b; b++) e = d[b], f.push(e);
					return f
				}(); d.length > 0;) {
				if (g = d.shift(), g === c) return i = g.nodeName.toLowerCase(), h.call(b, i) >= 0 ? f + 1 : f;
				switch (g.nodeType) {
				case Node.TEXT_NODE:
					f += g.textContent.length;
					break;
				case Node.ELEMENT_NODE:
					j = g.nodeName.toLowerCase(), h.call(b, j) >= 0 ? f += 1 : g.childNodes && Array.prototype.unshift.apply(d, function () {
						var a, b, c, d;
						for (c = g.childNodes, d = [], a = 0, b = c.length; b > a; a++) e = c[a], d.push(e);
						return d
					}())
				}
			}
			return f
		}, f = function (a, c) {
			var d, e, f, g, i, j, k, l, m, n, o, p, q, r;
			if (e = a.childNodes, m = c.cloneRange(), m.collapse(!0), i = c.cloneRange(), i.collapse(!1), k = m.startContainer, l = m.startOffset, f = i.endContainer, g = i.endOffset, !m.comparePoint) return [k, l, f, g];
			if (k === a)
				for (k = e[e.length - 1], l = k.textContent.length, j = n = 0, p = e.length; p > n; j = ++n)
					if (d = e[j], 1 === m.comparePoint(d, 0)) {
						0 === j ? (k = d, l = 0) : (k = e[j - 1], l = d.textContent.length), r = k.nodeName.toLowerCase, h.call(b, r) >= 0 && (l = 1);
						break
					}
			if (c.collapsed) return [k, l, k, l];
			if (f === a)
				for (f = e[e.length - 1], g = f.textContent.length, j = o = 0, q = e.length; q > o; j = ++o) d = e[j], 1 === i.comparePoint(d, 0) && (f = 0 === j ? d : e[j - 1], g = d.textContent.length + 1);
			return [k, l, f, g]
		}, "undefined" != typeof window && (window.ContentSelect = a), "undefined" != typeof module && module.exports && (c = module.exports = a)
	}.call(this),
	function () {
		var a, b, c, d, e, f = [].slice,
			g = [].indexOf || function (a) {
				for (var b = 0, c = this.length; c > b; b++)
					if (b in this && this[b] === a) return b;
				return -1
			},
			h = {}.hasOwnProperty,
			i = function (a, b) {
				function c() {
					this.constructor = a
				}
				for (var d in b) h.call(b, d) && (a[d] = b[d]);
				return c.prototype = b.prototype, a.prototype = new c, a.__super__ = b.prototype, a
			},
			j = function (a, b) {
				return function () {
					return a.apply(b, arguments)
				}
			};
		a = {
			ALIGNMENT_CLASS_NAMES: {
				left: "align-left",
				right: "align-right"
			},
			DEFAULT_MAX_ELEMENT_WIDTH: 800,
			DEFAULT_MIN_ELEMENT_WIDTH: 80,
			DRAG_HOLD_DURATION: 500,
			DROP_EDGE_SIZE: 50,
			HELPER_CHAR_LIMIT: 250,
			INDENT: "    ",
			LANGUAGE: "en",
			PREFER_LINE_BREAKS: !1,
			RESIZE_CORNER_SIZE: 15,
			_translations: {},
			_: function (b) {
				var c;
				return c = a.LANGUAGE, a._translations[c] && a._translations[c][b] ? a._translations[c][b] : b
			},
			addTranslations: function (b, c) {
				return a._translations[b] = c
			},
			addCSSClass: function (a, b) {
				var c, d, e;
				return a.classList ? void a.classList.add(b) : (d = a.getAttribute("class"), d ? (e = function () {
					var a, b, e, f;
					for (e = d.split(" "), f = [], a = 0, b = e.length; b > a; a++) c = e[a], f.push(c);
					return f
				}(), -1 === e.indexOf(b) ? a.setAttribute("class", "" + d + " " + b) : void 0) : a.setAttribute("class", b))
			},
			attributesToString: function (a) {
				var b, c, d, e, f, g;
				if (!a) return "";
				for (d = function () {
						var b;
						b = [];
						for (c in a) b.push(c);
						return b
					}(), d.sort(), b = [], f = 0, g = d.length; g > f; f++) c = d[f], e = a[c], "" === e ? b.push(c) : (e = HTMLString.String.encode(e), e = e.replace(/"/g, "&quot;"), b.push("" + c + '="' + e + '"'));
				return b.join(" ")
			},
			removeCSSClass: function (a, b) {
				var c, d, e, f;
				return a.classList ? (a.classList.remove(b), void(0 === a.classList.length && a.removeAttribute("class"))) : (d = a.getAttribute("class"), d && (f = function () {
					var a, b, e, f;
					for (e = d.split(" "), f = [], a = 0, b = e.length; b > a; a++) c = e[a], f.push(c);
					return f
				}(), e = f.indexOf(b), e > -1) ? (f.splice(e, 1), f.length ? a.setAttribute("class", f.join(" ")) : a.removeAttribute("class")) : void 0)
			}
		}, "undefined" != typeof window && (window.ContentEdit = a), "undefined" != typeof module && module.exports && (b = module.exports = a), d = function () {
			function b() {
				this._tagNames = {}
			}
			return b.prototype.register = function () {
				var a, b, c, d, e, g;
				for (a = arguments[0], c = 2 <= arguments.length ? f.call(arguments, 1) : [], g = [], d = 0, e = c.length; e > d; d++) b = c[d], g.push(this._tagNames[b.toLowerCase()] = a);
				return g
			}, b.prototype.match = function (b) {
				return this._tagNames[b.toLowerCase()] ? this._tagNames[b.toLowerCase()] : a.Static
			}, b
		}(), a.TagNames = function () {
			function a() {}
			var b;
			return b = null, a.get = function () {
				return null != b ? b : b = new d
			}, a
		}(), a.Node = function () {
			function b() {
				this._bindings = {}, this._parent = null, this._modified = null
			}
			return b.prototype.lastModified = function () {
				return this._modified
			}, b.prototype.parent = function () {
				return this._parent
			}, b.prototype.parents = function () {
				var a, b;
				for (b = [], a = this._parent; a;) b.push(a), a = a._parent;
				return b
			}, b.prototype.type = function () {
				return "Node"
			}, b.prototype.html = function (a) {
				throw null == a && (a = ""), new Error("`html` not implemented")
			}, b.prototype.bind = function (a, b) {
				return void 0 === this._bindings[a] && (this._bindings[a] = []), this._bindings[a].push(b), b
			}, b.prototype.trigger = function () {
				var a, b, c, d, e, g, h;
				if (c = arguments[0], a = 2 <= arguments.length ? f.call(arguments, 1) : [], this._bindings[c]) {
					for (g = this._bindings[c], h = [], d = 0, e = g.length; e > d; d++) b = g[d], b && h.push(b.call.apply(b, [this].concat(f.call(a))));
					return h
				}
			}, b.prototype.unbind = function (a, b) {
				var c, d, e, f, g, h;
				if (!a) return void(this._bindings = {});
				if (!b) return void(this._bindings[a] = void 0);
				if (this._bindings[a]) {
					for (g = this._bindings[a], h = [], c = e = 0, f = g.length; f > e; c = ++e) d = g[c], h.push(d === b ? this._bindings[a].splice(c, 1) : void 0);
					return h
				}
			}, b.prototype.commit = function () {
				return this._modified = null, a.Root.get().trigger("commit", this)
			}, b.prototype.taint = function () {
				var b, c, d, e, f, g;
				for (b = Date.now(), this._modified = b, g = this.parents(), e = 0, f = g.length; f > e; e++) c = g[e], c._modified = b;
				return d = a.Root.get(), d._modified = b, d.trigger("taint", this)
			}, b.prototype.closest = function (a) {
				var b;
				for (b = this.parent(); b && !a(b);) b = b.parent ? b.parent() : null;
				return b
			}, b.prototype.next = function () {
				var a, b, c, d, e, f;
				if (this.children && this.children.length > 0) return this.children[0];
				for (f = [this].concat(this.parents()), d = 0, e = f.length; e > d; d++) {
					if (c = f[d], !c.parent()) return null;
					if (a = c.parent().children, b = a.indexOf(c), b < a.length - 1) return a[b + 1]
				}
			}, b.prototype.nextContent = function () {
				return this.nextWithTest(function (a) {
					return void 0 !== a.content
				})
			}, b.prototype.nextSibling = function () {
				var a;
				return a = this.parent().children.indexOf(this), a === this.parent().children.length - 1 ? null : this.parent().children[a + 1]
			}, b.prototype.nextWithTest = function (a) {
				var b;
				for (b = this; b;)
					if (b = b.next(), b && a(b)) return b
			}, b.prototype.previous = function () {
				var a, b;
				if (!this.parent()) return null;
				if (a = this.parent().children, a[0] === this) return this.parent();
				for (b = a[a.indexOf(this) - 1]; b.children && b.children.length;) b = b.children[b.children.length - 1];
				return b
			}, b.prototype.previousContent = function () {
				var a;
				return a = this.previousWithTest(function (a) {
					return void 0 !== a.content
				})
			}, b.prototype.previousSibling = function () {
				var a;
				return a = this.parent().children.indexOf(this), 0 === a ? null : this.parent().children[a - 1]
			}, b.prototype.previousWithTest = function (a) {
				var b;
				for (b = this; b;)
					if (b = b.previous(), b && a(b)) return b
			}, b.extend = function (a) {
				var b, c, d;
				d = a.prototype;
				for (b in d) c = d[b], "constructor" !== b && (this.prototype[b] = c);
				for (b in a) c = a[b], g.call("__super__", b) >= 0 || (this.prototype[b] = c);
				return this
			}, b.fromDOMElement = function () {
				throw new Error("`fromDOMElement` not implemented")
			}, b
		}(), a.NodeCollection = function (b) {
			function c() {
				c.__super__.constructor.call(this), this.children = []
			}
			return i(c, b), c.prototype.descendants = function () {
				var a, b, c;
				for (a = [], c = this.children.slice(); c.length > 0;) b = c.shift(), a.push(b), b.children && b.children.length > 0 && (c = b.children.slice().concat(c));
				return a
			}, c.prototype.isMounted = function () {
				return !1
			}, c.prototype.type = function () {
				return "NodeCollection"
			}, c.prototype.attach = function (b, c) {
				return b.parent() && b.parent().detach(b), b._parent = this, void 0 !== c ? this.children.splice(c, 0, b) : this.children.push(b), b.mount && this.isMounted() && b.mount(), this.taint(), a.Root.get().trigger("attach", this, b)
			}, c.prototype.commit = function () {
				var b, c, d, e;
				for (e = this.descendants(), c = 0, d = e.length; d > c; c++) b = e[c], b._modified = null;
				return this._modified = null, a.Root.get().trigger("commit", this)
			}, c.prototype.detach = function (b) {
				var c;
				return c = this.children.indexOf(b), -1 !== c ? (b.unmount && this.isMounted() && b.isMounted() && b.unmount(), this.children.splice(c, 1), b._parent = null, this.taint(), a.Root.get().trigger("detach", this, b)) : void 0
			}, c
		}(a.Node), a.Element = function (b) {
			function c(a, b) {
				c.__super__.constructor.call(this), this._tagName = a.toLowerCase(), this._attributes = b ? b : {}, this._domElement = null, this._behaviours = {
					drag: !0,
					drop: !0,
					merge: !0,
					remove: !0,
					resize: !0,
					spawn: !0
				}
			}
			return i(c, b), c.prototype.attributes = function () {
				var a, b, c, d;
				a = {}, d = this._attributes;
				for (b in d) c = d[b], a[b] = c;
				return a
			}, c.prototype.cssTypeName = function () {
				return "element"
			}, c.prototype.domElement = function () {
				return this._domElement
			}, c.prototype.isFixed = function () {
				return this.parent() && "Fixture" === this.parent().type()
			}, c.prototype.isFocused = function () {
				return a.Root.get().focused() === this
			}, c.prototype.isMounted = function () {
				return null !== this._domElement
			}, c.prototype.type = function () {
				return "Element"
			}, c.prototype.typeName = function () {
				return "Element"
			}, c.prototype.addCSSClass = function (a) {
				var b;
				return b = !1, this.hasCSSClass(a) || (b = !0, this.attr("class") ? this.attr("class", "" + this.attr("class") + " " + a) : this.attr("class", a)), this._addCSSClass(a), b ? this.taint() : void 0
			}, c.prototype.attr = function (a, b) {
				return a = a.toLowerCase(), void 0 === b ? this._attributes[a] : (this._attributes[a] = b, this.isMounted() && "class" !== a.toLowerCase() && this._domElement.setAttribute(a, b), this.taint())
			}, c.prototype.blur = function () {
				var b;
				return b = a.Root.get(), this.isFocused() ? (this._removeCSSClass("ce-element--focused"), b._focused = null, b.trigger("blur", this)) : void 0
			}, c.prototype.can = function (a, b) {
				return void 0 === b ? !this.isFixed() && this._behaviours[a] : this._behaviours[a] = b
			}, c.prototype.createDraggingDOMElement = function () {
				var b;
				if (this.isMounted()) return b = document.createElement("div"), b.setAttribute("class", "ce-drag-helper ce-drag-helper--type-" + this.cssTypeName()), b.setAttribute("data-ce-type", a._(this.typeName())), b
			}, c.prototype.drag = function (b, c) {
				var d;
				if (this.isMounted() && this.can("drag")) return d = a.Root.get(), d.startDragging(this, b, c), d.trigger("drag", this)
			}, c.prototype.drop = function (b, c) {
				var d;
				if (this.can("drop")) {
					if (d = a.Root.get(), b) {
						if (b._removeCSSClass("ce-element--drop"), b._removeCSSClass("ce-element--drop-" + c[0]), b._removeCSSClass("ce-element--drop-" + c[1]), this.constructor.droppers[b.type()]) return this.constructor.droppers[b.type()](this, b, c), void d.trigger("drop", this, b, c);
						if (b.constructor.droppers[this.type()]) return b.constructor.droppers[this.type()](this, b, c), void d.trigger("drop", this, b, c)
					}
					return d.trigger("drop", this, null, null)
				}
			}, c.prototype.focus = function (b) {
				var c;
				return c = a.Root.get(), this.isFocused() ? void 0 : (c.focused() && c.focused().blur(), this._addCSSClass("ce-element--focused"), c._focused = this, this.isMounted() && !b && this.domElement().focus(), c.trigger("focus", this))
			}, c.prototype.hasCSSClass = function (a) {
				var b, c;
				return this.attr("class") && (c = function () {
					var a, c, d, e;
					for (d = this.attr("class").split(" "), e = [], a = 0, c = d.length; c > a; a++) b = d[a], e.push(b);
					return e
				}.call(this), c.indexOf(a) > -1) ? !0 : !1
			}, c.prototype.merge = function (a) {
				return this.can("merge") && this.can("remove") ? this.constructor.mergers[a.type()] ? this.constructor.mergers[a.type()](a, this) : a.constructor.mergers[this.type()] ? a.constructor.mergers[this.type()](a, this) : void 0 : !1
			}, c.prototype.mount = function () {
				var b;
				return this._domElement || (this._domElement = document.createElement(this.tagName())), b = this.nextSibling(), b ? this.parent().domElement().insertBefore(this._domElement, b.domElement()) : this.isFixed() ? (this.parent().domElement().parentNode.replaceChild(this._domElement, this.parent().domElement()), this.parent()._domElement = this._domElement) : this.parent().domElement().appendChild(this._domElement), this._addDOMEventListeners(), this._addCSSClass("ce-element"), this._addCSSClass("ce-element--type-" + this.cssTypeName()), this.isFocused() && this._addCSSClass("ce-element--focused"), a.Root.get().trigger("mount", this)
			}, c.prototype.removeAttr = function (a) {
				return a = a.toLowerCase(), this._attributes[a] ? (delete this._attributes[a], this.isMounted() && "class" !== a.toLowerCase() && this._domElement.removeAttribute(a), this.taint()) : void 0
			}, c.prototype.removeCSSClass = function (a) {
				var b, c, d;
				if (this.hasCSSClass(a)) return d = function () {
					var a, c, d, e;
					for (d = this.attr("class").split(" "), e = [], a = 0, c = d.length; c > a; a++) b = d[a], e.push(b);
					return e
				}.call(this), c = d.indexOf(a), c > -1 && d.splice(c, 1), d.length ? this.attr("class", d.join(" ")) : this.removeAttr("class"), this._removeCSSClass(a), this.taint()
			}, c.prototype.tagName = function (a) {
				return void 0 === a ? this._tagName : (this._tagName = a.toLowerCase(), this.isMounted() && (this.unmount(), this.mount()), this.taint())
			}, c.prototype.unmount = function () {
				return this._removeDOMEventListeners(), this.isFixed() ? (this._removeCSSClass("ce-element"), this._removeCSSClass("ce-element--type-" + this.cssTypeName()), void this._removeCSSClass("ce-element--focused")) : (this._domElement.parentNode && this._domElement.parentNode.removeChild(this._domElement), this._domElement = null, a.Root.get().trigger("unmount", this))
			}, c.prototype._addDOMEventListeners = function () {
				var a, b, c, d;
				this._domEventHandlers = {
					dragstart: function () {
						return function (a) {
							return a.preventDefault()
						}
					}(this),
					focus: function () {
						return function (a) {
							return a.preventDefault()
						}
					}(this),
					keydown: function (a) {
						return function (b) {
							return a._onKeyDown(b)
						}
					}(this),
					keyup: function (a) {
						return function (b) {
							return a._onKeyUp(b)
						}
					}(this),
					mousedown: function (a) {
						return function (b) {
							return 0 === b.button ? a._onMouseDown(b) : void 0
						}
					}(this),
					mousemove: function (a) {
						return function (b) {
							return a._onMouseMove(b)
						}
					}(this),
					mouseover: function (a) {
						return function (b) {
							return a._onMouseOver(b)
						}
					}(this),
					mouseout: function (a) {
						return function (b) {
							return a._onMouseOut(b)
						}
					}(this),
					mouseup: function (a) {
						return function (b) {
							return 0 === b.button ? a._onMouseUp(b) : void 0
						}
					}(this),
					dragover: function () {
						return function (a) {
							return a.preventDefault()
						}
					}(this),
					drop: function (a) {
						return function (b) {
							return a._onNativeDrop(b)
						}
					}(this),
					paste: function (a) {
						return function (b) {
							return a._onPaste(b)
						}
					}(this)
				}, c = this._domEventHandlers, d = [];
				for (b in c) a = c[b], d.push(this._domElement.addEventListener(b, a));
				return d
			}, c.prototype._onKeyDown = function () {}, c.prototype._onKeyUp = function () {}, c.prototype._onMouseDown = function () {
				return this.focus ? this.focus(!0) : void 0
			}, c.prototype._onMouseMove = function (a) {
				return this._onOver(a)
			}, c.prototype._onMouseOver = function (a) {
				return this._onOver(a)
			}, c.prototype._onMouseOut = function () {
				var b, c;
				return this._removeCSSClass("ce-element--over"), c = a.Root.get(), b = c.dragging(), b ? (this._removeCSSClass("ce-element--drop"), this._removeCSSClass("ce-element--drop-above"), this._removeCSSClass("ce-element--drop-below"), this._removeCSSClass("ce-element--drop-center"), this._removeCSSClass("ce-element--drop-left"), this._removeCSSClass("ce-element--drop-right"), c._dropTarget = null) : void 0
			}, c.prototype._onMouseUp = function () {}, c.prototype._onNativeDrop = function (b) {
				return b.preventDefault(), b.stopPropagation(), a.Root.get().trigger("native-drop", this, b)
			}, c.prototype._onPaste = function (b) {
				return b.preventDefault(), b.stopPropagation(), a.Root.get().trigger("paste", this, b)
			}, c.prototype._onOver = function () {
				var b, c;
				return this._addCSSClass("ce-element--over"), c = a.Root.get(), b = c.dragging(), b && b !== this && !c._dropTarget && this.can("drop") && (this.constructor.droppers[b.type()] || b.constructor.droppers[this.type()]) ? (this._addCSSClass("ce-element--drop"), c._dropTarget = this) : void 0
			}, c.prototype._removeDOMEventListeners = function () {
				var a, b, c, d;
				c = this._domEventHandlers, d = [];
				for (b in c) a = c[b], d.push(this._domElement.removeEventListener(b, a));
				return d
			}, c.prototype._addCSSClass = function (b) {
				return this.isMounted() ? a.addCSSClass(this._domElement, b) : void 0
			}, c.prototype._attributesToString = function () {
				return Object.getOwnPropertyNames(this._attributes).length > 0 ? " " + a.attributesToString(this._attributes) : ""
			}, c.prototype._removeCSSClass = function (b) {
				return this.isMounted() ? a.removeCSSClass(this._domElement, b) : void 0
			}, c.droppers = {}, c.mergers = {}, c.placements = ["above", "below"], c.getDOMElementAttributes = function (a) {
				var b, c, d, e, f;
				if (!a.hasAttributes()) return {};
				for (c = {}, f = a.attributes, d = 0, e = f.length; e > d; d++) b = f[d], c[b.name.toLowerCase()] = b.value;
				return c
			}, c._dropVert = function (a, b, c) {
				var d;
				return a.parent().detach(a), d = b.parent().children.indexOf(b), "below" === c[0] && (d += 1), b.parent().attach(a, d)
			}, c._dropBoth = function (b, c, d) {
				var e, f, g, h, i, j, k, l;
				if (b.parent().detach(b), i = c.parent().children.indexOf(c), "below" === d[0] && "center" === d[1] && (i += 1), f = a.ALIGNMENT_CLASS_NAMES.left, g = a.ALIGNMENT_CLASS_NAMES.right, b.a) {
					if (b._removeCSSClass(f), b._removeCSSClass(g), b.a["class"]) {
						for (e = [], l = b.a["class"].split(" "), j = 0, k = l.length; k > j; j++) h = l[j], h !== f && h !== g && e.push(h);
						e.length ? b.a["class"] = e.join(" ") : delete b.a["class"]
					}
				} else b.removeCSSClass(f), b.removeCSSClass(g);
				return "left" === d[1] && (b.a ? (b.a["class"] ? b.a["class"] += " " + f : b.a["class"] = f, b._addCSSClass(f)) : b.addCSSClass(f)), "right" === d[1] && (b.a ? (b.a["class"] ? b.a["class"] += " " + g : b.a["class"] = g, b._addCSSClass(g)) : b.addCSSClass(g)), c.parent().attach(b, i)
			}, c
		}(a.Node), a.ElementCollection = function (b) {
			function c(b, d) {
				c.__super__.constructor.call(this, b, d), a.NodeCollection.prototype.constructor.call(this)
			}
			return i(c, b), c.extend(a.NodeCollection), c.prototype.cssTypeName = function () {
				return "element-collection"
			}, c.prototype.isMounted = function () {
				return null !== this._domElement
			}, c.prototype.type = function () {
				return "ElementCollection"
			}, c.prototype.createDraggingDOMElement = function () {
				var b, d;
				if (this.isMounted()) return b = c.__super__.createDraggingDOMElement.call(this), d = this._domElement.textContent, d.length > a.HELPER_CHAR_LIMIT && (d = d.substr(0, a.HELPER_CHAR_LIMIT)), b.innerHTML = d, b
			}, c.prototype.detach = function (b) {
				return a.NodeCollection.prototype.detach.call(this, b), 0 === this.children.length && this.parent() ? this.parent().detach(this) : void 0
			}, c.prototype.html = function (b) {
				var c, d;
				return null == b && (b = ""), d = function () {
					var d, e, f, g;
					for (f = this.children, g = [], d = 0, e = f.length; e > d; d++) c = f[d], g.push(c.html(b + a.INDENT));
					return g
				}.call(this), this.isFixed() ? d.join("\n") : "" + b + "<" + this.tagName() + this._attributesToString() + ">\n" + ("" + d.join("\n") + "\n") + ("" + b + "</" + this.tagName() + ">")
			}, c.prototype.mount = function () {
				var a, b, d, e, f, g, h, i;
				this._domElement = document.createElement(this._tagName), g = this._attributes;
				for (b in g) d = g[b], this._domElement.setAttribute(b, d);
				for (c.__super__.mount.call(this), h = this.children, i = [], e = 0, f = h.length; f > e; e++) a = h[e], i.push(a.mount());
				return i
			}, c.prototype.unmount = function () {
				var a, b, d, e;
				for (e = this.children, b = 0, d = e.length; d > b; b++) a = e[b], a.unmount();
				return c.__super__.unmount.call(this)
			}, c.prototype.blur = void 0, c.prototype.focus = void 0, c
		}(a.Element), a.ResizableElement = function (b) {
			function c(a, b) {
				c.__super__.constructor.call(this, a, b), this._domSizeInfoElement = null, this._aspectRatio = 1
			}
			return i(c, b), c.prototype.aspectRatio = function () {
				return this._aspectRatio
			}, c.prototype.maxSize = function () {
				var b;
				return b = parseInt(this.attr("data-ce-max-width") || 0), b || (b = a.DEFAULT_MAX_ELEMENT_WIDTH), b = Math.max(b, this.size()[0]), [b, b * this.aspectRatio()]
			}, c.prototype.minSize = function () {
				var b;
				return b = parseInt(this.attr("data-ce-min-width") || 0), b || (b = a.DEFAULT_MIN_ELEMENT_WIDTH), b = Math.min(b, this.size()[0]), [b, b * this.aspectRatio()]
			}, c.prototype.type = function () {
				return "ResizableElement"
			}, c.prototype.mount = function () {
				return c.__super__.mount.call(this), this._domElement.setAttribute("data-ce-size", this._getSizeInfo())
			}, c.prototype.resize = function (b, c, d) {
				return this.isMounted() && this.can("resize") ? a.Root.get().startResizing(this, b, c, d, !0) : void 0
			}, c.prototype.size = function (a) {
				var b, c, d, e;
				return a ? (a[0] = parseInt(a[0]), a[1] = parseInt(a[1]), d = this.minSize(), a[0] = Math.max(a[0], d[0]), a[1] = Math.max(a[1], d[1]), c = this.maxSize(), a[0] = Math.min(a[0], c[0]), a[1] = Math.min(a[1], c[1]), this.attr("width", parseInt(a[0])), this.attr("height", parseInt(a[1])), this.isMounted() ? (this._domElement.style.width = "" + a[0] + "px", this._domElement.style.height = "" + a[1] + "px", this._domElement.setAttribute("data-ce-size", this._getSizeInfo())) : void 0) : (e = parseInt(this.attr("width") || 1), b = parseInt(this.attr("height") || 1), [e, b])
			}, c.prototype._onMouseDown = function (a) {
				var b;
				return c.__super__._onMouseDown.call(this, a), b = this._getResizeCorner(a.clientX, a.clientY), b ? this.resize(b, a.clientX, a.clientY) : (clearTimeout(this._dragTimeout), this._dragTimeout = setTimeout(function (b) {
					return function () {
						return b.drag(a.pageX, a.pageY)
					}
				}(this), 150))
			}, c.prototype._onMouseMove = function (a) {
				var b;
				return c.__super__._onMouseMove.call(this), this.can("resize") ? (this._removeCSSClass("ce-element--resize-top-left"), this._removeCSSClass("ce-element--resize-top-right"), this._removeCSSClass("ce-element--resize-bottom-left"), this._removeCSSClass("ce-element--resize-bottom-right"), b = this._getResizeCorner(a.clientX, a.clientY), b ? this._addCSSClass("ce-element--resize-" + b[0] + "-" + b[1]) : void 0) : void 0
			}, c.prototype._onMouseOut = function () {
				return c.__super__._onMouseOut.call(this), this._removeCSSClass("ce-element--resize-top-left"), this._removeCSSClass("ce-element--resize-top-right"), this._removeCSSClass("ce-element--resize-bottom-left"), this._removeCSSClass("ce-element--resize-bottom-right")
			}, c.prototype._onMouseUp = function () {
				return c.__super__._onMouseUp.call(this), this._dragTimeout ? clearTimeout(this._dragTimeout) : void 0
			}, c.prototype._getResizeCorner = function (b, c) {
				var d, e, f, g, h;
				return f = this._domElement.getBoundingClientRect(), h = [b - f.left, c - f.top], b = h[0], c = h[1], g = this.size(), e = a.RESIZE_CORNER_SIZE, e = Math.min(e, Math.max(parseInt(g[0] / 4), 1)), e = Math.min(e, Math.max(parseInt(g[1] / 4), 1)), d = null, e > b ? e > c ? d = ["top", "left"] : c > f.height - e && (d = ["bottom", "left"]) : b > f.width - e && (e > c ? d = ["top", "right"] : c > f.height - e && (d = ["bottom", "right"])), d
			}, c.prototype._getSizeInfo = function () {
				var a;
				return a = this.size(), "w " + a[0] + " × h " + a[1]
			}, c
		}(a.Element), a.Region = function (b) {
			function c(a) {
				c.__super__.constructor.call(this), this._domElement = a, this.setContent(a)
			}
			return i(c, b), c.prototype.domElement = function () {
				return this._domElement
			}, c.prototype.isMounted = function () {
				return !0
			}, c.prototype.type = function () {
				return "Region"
			}, c.prototype.html = function (a) {
				var b;
				return null == a && (a = ""),
					function () {
						var c, d, e, f;
						for (e = this.children, f = [], c = 0, d = e.length; d > c; c++) b = e[c], f.push(b.html(a));
						return f
					}.call(this).join("\n").trim()
			}, c.prototype.setContent = function (b) {
				var c, d, e, f, g, h, i, j, k, l, m, n, o, p;
				for (h = b, void 0 === b.childNodes && (k = document.createElement("div"), k.innerHTML = b, h = k), p = this.children.slice(), l = 0, n = p.length; n > l; l++) d = p[l], this.detach(d);
				for (j = a.TagNames.get(), f = function () {
						var a, b, d, e;
						for (d = h.childNodes, e = [], a = 0, b = d.length; b > a; a++) c = d[a], e.push(c);
						return e
					}(), m = 0, o = f.length; o > m; m++) e = f[m], 1 === e.nodeType && (g = j.match(e.getAttribute("data-ce-tag") ? e.getAttribute("data-ce-tag") : e.tagName), i = g.fromDOMElement(e), h.removeChild(e), i && this.attach(i));
				return a.Root.get().trigger("ready", this)
			}, c
		}(a.NodeCollection), a.Fixture = function (b) {
			function c(b) {
				var d, e, f;
				c.__super__.constructor.call(this), this._domElement = b, f = a.TagNames.get(), d = f.match(this._domElement.getAttribute("data-ce-tag") ? this._domElement.getAttribute("data-ce-tag") : this._domElement.tagName), e = d.fromDOMElement(this._domElement), this.children = [e], e._parent = this, e.mount(), a.Root.get().trigger("ready", this)
			}
			return i(c, b), c.prototype.domElement = function () {
				return this._domElement
			}, c.prototype.isMounted = function () {
				return !0
			}, c.prototype.type = function () {
				return "Fixture"
			}, c.prototype.html = function (a) {
				var b;
				return null == a && (a = ""),
					function () {
						var c, d, e, f;
						for (e = this.children, f = [], c = 0, d = e.length; d > c; c++) b = e[c], f.push(b.html(a));
						return f
					}.call(this).join("\n").trim()
			}, c
		}(a.NodeCollection), c = function (b) {
			function c() {
				this._onStopResizing = j(this._onStopResizing, this), this._onResize = j(this._onResize, this), this._onStopDragging = j(this._onStopDragging, this), this._onDrag = j(this._onDrag, this), c.__super__.constructor.call(this), this._focused = null, this._dragging = null, this._dropTarget = null, this._draggingDOMElement = null, this._resizing = null, this._resizingInit = null
			}
			return i(c, b), c.prototype.dragging = function () {
				return this._dragging
			}, c.prototype.dropTarget = function () {
				return this._dropTarget
			}, c.prototype.focused = function () {
				return this._focused
			}, c.prototype.resizing = function () {
				return this._resizing
			}, c.prototype.type = function () {
				return "Root"
			}, c.prototype.cancelDragging = function () {
				return this._dragging ? (document.body.removeChild(this._draggingDOMElement), document.removeEventListener("mousemove", this._onDrag), document.removeEventListener("mouseup", this._onStopDragging), this._dragging._removeCSSClass("ce-element--dragging"), this._dragging = null, this._dropTarget = null, a.removeCSSClass(document.body, "ce--dragging")) : void 0
			}, c.prototype.startDragging = function (b, c, d) {
				return this._dragging ? void 0 : (this._dragging = b, this._dragging._addCSSClass("ce-element--dragging"), this._draggingDOMElement = this._dragging.createDraggingDOMElement(), document.body.appendChild(this._draggingDOMElement), this._draggingDOMElement.style.left = "" + c + "px", this._draggingDOMElement.style.top = "" + d + "px", document.addEventListener("mousemove", this._onDrag), document.addEventListener("mouseup", this._onStopDragging), a.addCSSClass(document.body, "ce--dragging"))
			}, c.prototype._getDropPlacement = function (b, c) {
				var d, e, f, g;
				return this._dropTarget ? (e = this._dropTarget.domElement().getBoundingClientRect(), g = [b - e.left, c - e.top], b = g[0], c = g[1], d = "center", b < a.DROP_EDGE_SIZE ? d = "left" : b > e.width - a.DROP_EDGE_SIZE && (d = "right"), f = "above", c > e.height / 2 && (f = "below"), [f, d]) : null
			}, c.prototype._onDrag = function (a) {
				var b, c, d;
				return ContentSelect.Range.unselectAll(), this._draggingDOMElement.style.left = "" + a.pageX + "px", this._draggingDOMElement.style.top = "" + a.pageY + "px", this._dropTarget && (b = this._getDropPlacement(a.clientX, a.clientY), this._dropTarget._removeCSSClass("ce-element--drop-above"), this._dropTarget._removeCSSClass("ce-element--drop-below"), this._dropTarget._removeCSSClass("ce-element--drop-center"), this._dropTarget._removeCSSClass("ce-element--drop-left"), this._dropTarget._removeCSSClass("ce-element--drop-right"), c = b[0], g.call(this._dragging.constructor.placements, c) >= 0 && this._dropTarget._addCSSClass("ce-element--drop-" + b[0]), d = b[1], g.call(this._dragging.constructor.placements, d) >= 0) ? this._dropTarget._addCSSClass("ce-element--drop-" + b[1]) : void 0
			}, c.prototype._onStopDragging = function (a) {
				var b;
				return b = this._getDropPlacement(a.clientX, a.clientY), this._dragging.drop(this._dropTarget, b), this.cancelDragging()
			}, c.prototype.startResizing = function (b, c, d, e, f) {
				var g, h;
				if (!this._resizing) return this._resizing = b, this._resizingInit = {
					corner: c,
					fixed: f,
					origin: [d, e],
					size: b.size()
				}, this._resizing._addCSSClass("ce-element--resizing"), h = this._resizing.parent().domElement(), g = document.createElement("div"), g.setAttribute("class", "ce-measure"), h.appendChild(g), this._resizingParentWidth = g.getBoundingClientRect().width, h.removeChild(g), document.addEventListener("mousemove", this._onResize), document.addEventListener("mouseup", this._onStopResizing), a.addCSSClass(document.body, "ce--resizing")
			}, c.prototype._onResize = function (a) {
				var b, c, d, e;
				return ContentSelect.Range.unselectAll(), d = this._resizingInit.origin[0] - a.clientX, "right" === this._resizingInit.corner[1] && (d = -d), c = this._resizingInit.size[0] + d, c = Math.min(c, this._resizingParentWidth), this._resizingInit.fixed ? b = c * this._resizing.aspectRatio() : (e = this._resizingInit.origin[1] - a.clientY, "bottom" === this._resizingInit.corner[0] && (e = -e), b = this._resizingInit.size[1] + e), this._resizing.size([c, b])
			}, c.prototype._onStopResizing = function () {
				return document.removeEventListener("mousemove", this._onResize), document.removeEventListener("mouseup", this._onStopResizing), this._resizing._removeCSSClass("ce-element--resizing"), this._resizing = null, this._resizingInit = null, this._resizingParentWidth = null, a.removeCSSClass(document.body, "ce--resizing")
			}, c
		}(a.Node), a.Root = function () {
			function a() {}
			var b;
			return b = null, a.get = function () {
				return null != b ? b : b = new c
			}, a
		}(), a.Static = function (b) {
			function c(a, b, d) {
				c.__super__.constructor.call(this, a, b), this._content = d
			}
			return i(c, b), c.prototype.cssTypeName = function () {
				return "static"
			}, c.prototype.type = function () {
				return "Static"
			}, c.prototype.typeName = function () {
				return "Static"
			}, c.prototype.createDraggingDOMElement = function () {
				var b, d;
				if (this.isMounted()) return b = c.__super__.createDraggingDOMElement.call(this), d = this._domElement.textContent, d.length > a.HELPER_CHAR_LIMIT && (d = d.substr(0, a.HELPER_CHAR_LIMIT)), b.innerHTML = d, b
			}, c.prototype.html = function (a) {
				return null == a && (a = ""), HTMLString.Tag.SELF_CLOSING[this._tagName] ? "" + a + "<" + this._tagName + this._attributesToString() + ">" : "" + a + "<" + this._tagName + this._attributesToString() + ">" + this._content + ("" + a + "</" + this._tagName + ">")
			}, c.prototype.mount = function () {
				var a, b, d;
				this._domElement = document.createElement(this._tagName), d = this._attributes;
				for (a in d) b = d[a], this._domElement.setAttribute(a, b);
				return this._domElement.innerHTML = this._content, c.__super__.mount.call(this)
			}, c.prototype.blur = void 0, c.prototype.focus = void 0, c.prototype._onMouseDown = function (a) {
				return c.__super__._onMouseDown.call(this, a), void 0 !== this.attr("data-ce-moveable") ? (clearTimeout(this._dragTimeout), this._dragTimeout = setTimeout(function (b) {
					return function () {
						return b.drag(a.pageX, a.pageY)
					}
				}(this), 150)) : void 0
			}, c.prototype._onMouseOver = function (a) {
				return c.__super__._onMouseOver.call(this, a), this._removeCSSClass("ce-element--over")
			}, c.prototype._onMouseUp = function (a) {
				return c.__super__._onMouseUp.call(this, a), this._dragTimeout ? clearTimeout(this._dragTimeout) : void 0
			}, c.droppers = {
				Static: a.Element._dropVert
			}, c.fromDOMElement = function (a) {
				return new this(a.tagName, this.getDOMElementAttributes(a), a.innerHTML)
			}, c
		}(a.Element), a.TagNames.get().register(a.Static, "static"), a.Text = function (b) {
			function c(a, b, d) {
				c.__super__.constructor.call(this, a, b), this.content = d instanceof HTMLString.String ? d : new HTMLString.String(d).trim()
			}
			return i(c, b), c.prototype.cssTypeName = function () {
				return "text"
			}, c.prototype.type = function () {
				return "Text"
			}, c.prototype.typeName = function () {
				return "Text"
			}, c.prototype.blur = function () {
				var a;
				if (this.isMounted() && this._syncContent(), this.content.isWhitespace() && this.can("remove")) this.parent() && this.parent().detach(this);
				else if (this.isMounted()) {
					try {
						this._domElement.blur()
					} catch (b) {
						a = b
					}
					this._domElement.removeAttribute("contenteditable")
				}
				return c.__super__.blur.call(this)
			}, c.prototype.createDraggingDOMElement = function () {
				var b, d;
				if (this.isMounted()) return b = c.__super__.createDraggingDOMElement.call(this), d = HTMLString.String.encode(this._domElement.textContent), d.length > a.HELPER_CHAR_LIMIT && (d = d.substr(0, a.HELPER_CHAR_LIMIT)), b.innerHTML = d, b
			}, c.prototype.drag = function (a, b) {
				return this.storeState(), this._domElement.removeAttribute("contenteditable"), c.__super__.drag.call(this, a, b)
			}, c.prototype.drop = function (a, b) {
				return c.__super__.drop.call(this, a, b), this.restoreState()
			}, c.prototype.focus = function (a) {
				return this.isMounted() && this._domElement.setAttribute("contenteditable", ""), c.__super__.focus.call(this, a)
			}, c.prototype.html = function (b) {
				var c;
				return null == b && (b = ""), (!this._lastCached || this._lastCached < this._modified) && (c = this.content.copy().trim(), c.optimize(), this._lastCached = Date.now(), this._cached = c.html()), this.isFixed() ? this._cached : "" + b + "<" + this._tagName + this._attributesToString() + ">\n" + ("" + b + a.INDENT + this._cached + "\n") + ("" + b + "</" + this._tagName + ">")
			}, c.prototype.mount = function () {
				var a, b, d;
				this._domElement = document.createElement(this._tagName), d = this._attributes;
				for (a in d) b = d[a], this._domElement.setAttribute(a, b);
				return this.updateInnerHTML(), c.__super__.mount.call(this)
			}, c.prototype.restoreState = function () {
				return this._savedSelection ? this.isMounted() && this.isFocused() ? (this._domElement.setAttribute("contenteditable", ""), this._addCSSClass("ce-element--focused"), document.activeElement !== this.domElement() && this.domElement().focus(), this._savedSelection.select(this._domElement), this._savedSelection = void 0) : void(this._savedSelection = void 0) : void 0
			}, c.prototype.selection = function (a) {
				return void 0 === a ? this.isMounted() ? ContentSelect.Range.query(this._domElement) : new ContentSelect.Range(0, 0) : a.select(this._domElement)
			}, c.prototype.storeState = function () {
				return this.isMounted() && this.isFocused() ? this._savedSelection = ContentSelect.Range.query(this._domElement) : void 0
			}, c.prototype.unmount = function () {
				return this._domElement.removeAttribute("contenteditable"), c.__super__.unmount.call(this)
			}, c.prototype.updateInnerHTML = function () {
				return this._domElement.innerHTML = this.content.html(), ContentSelect.Range.prepareElement(this._domElement), this._flagIfEmpty()
			}, c.prototype._onKeyDown = function (a) {
				switch (a.keyCode) {
				case 40:
					return this._keyDown(a);
				case 37:
					return this._keyLeft(a);
				case 39:
					return this._keyRight(a);
				case 38:
					return this._keyUp(a);
				case 9:
					return this._keyTab(a);
				case 8:
					return this._keyBack(a);
				case 46:
					return this._keyDelete(a);
				case 13:
					return this._keyReturn(a)
				}
			}, c.prototype._onKeyUp = function (a) {
				return c.__super__._onKeyUp.call(this, a), this._syncContent()
			}, c.prototype._onMouseDown = function (b) {
				return c.__super__._onMouseDown.call(this, b), clearTimeout(this._dragTimeout), this._dragTimeout = setTimeout(function (a) {
					return function () {
						return a.drag(b.pageX, b.pageY)
					}
				}(this), a.DRAG_HOLD_DURATION), 0 === this.content.length() && a.Root.get().focused() === this ? (b.preventDefault(), document.activeElement !== this._domElement && this._domElement.focus(), new ContentSelect.Range(0, 0).select(this._domElement)) : void 0
			}, c.prototype._onMouseMove = function (a) {
				return this._dragTimeout && clearTimeout(this._dragTimeout), c.__super__._onMouseMove.call(this, a)
			}, c.prototype._onMouseOut = function (a) {
				return this._dragTimeout && clearTimeout(this._dragTimeout), c.__super__._onMouseOut.call(this, a)
			}, c.prototype._onMouseUp = function (a) {
				return this._dragTimeout && clearTimeout(this._dragTimeout), c.__super__._onMouseUp.call(this, a)
			}, c.prototype._keyBack = function (a) {
				var b, c;
				return c = ContentSelect.Range.query(this._domElement), 0 === c.get()[0] && c.isCollapsed() ? (a.preventDefault(), b = this.previousContent(), this._syncContent(), b ? b.merge(this) : void 0) : void 0
			}, c.prototype._keyDelete = function (a) {
				var b, c;
				return c = ContentSelect.Range.query(this._domElement), this._atEnd(c) && c.isCollapsed() ? (a.preventDefault(), b = this.nextContent(), b ? this.merge(b) : void 0) : void 0
			}, c.prototype._keyDown = function (a) {
				return this._keyRight(a)
			}, c.prototype._keyLeft = function (b) {
				var c, d;
				return d = ContentSelect.Range.query(this._domElement), 0 === d.get()[0] && d.isCollapsed() ? (b.preventDefault(), c = this.previousContent(), c ? (c.focus(), d = new ContentSelect.Range(c.content.length(), c.content.length()), d.select(c.domElement())) : a.Root.get().trigger("previous-region", this.closest(function (a) {
					return "Region" === a.type()
				}))) : void 0
			}, c.prototype._keyReturn = function (b) {
				var c, d, e, f, g, h;
				if (b.preventDefault(), !this.content.isWhitespace()) {
					if (f = ContentSelect.Range.query(this._domElement), h = this.content.substring(0, f.get()[0]), g = this.content.substring(f.get()[1]), b.shiftKey ^ a.PREFER_LINE_BREAKS) return d = f.get()[0], e = "<br>", this.content.length() === d && (this.content.characters[d - 1].isTag("br") || (e = "<br><br>")), this.content = this.content.insert(d, new HTMLString.String(e, !0), !0), this.updateInnerHTML(), d += 1, f = new ContentSelect.Range(d, d), f.select(this.domElement()), void this.taint();
					if (this.can("spawn")) return this.content = h.trim(), this.updateInnerHTML(), c = new this.constructor("p", {}, g.trim()), this.parent().attach(c, this.parent().children.indexOf(this) + 1), h.length() ? (c.focus(), f = new ContentSelect.Range(0, 0), f.select(c.domElement())) : (f = new ContentSelect.Range(0, h.length()), f.select(this._domElement)), this.taint()
				}
			}, c.prototype._keyRight = function (b) {
				var c, d;
				return d = ContentSelect.Range.query(this._domElement), this._atEnd(d) && d.isCollapsed() ? (b.preventDefault(), c = this.nextContent(), c ? (c.focus(), d = new ContentSelect.Range(0, 0), d.select(c.domElement())) : a.Root.get().trigger("next-region", this.closest(function (a) {
					return "Fixture" === a.type() || "Region" === a.type()
				}))) : void 0
			}, c.prototype._keyTab = function (a) {
				return a.preventDefault()
			}, c.prototype._keyUp = function (a) {
				return this._keyLeft(a)
			}, c.prototype._atEnd = function (a) {
				return a.get()[0] >= this.content.length()
			}, c.prototype._flagIfEmpty = function () {
				return 0 === this.content.length() ? this._addCSSClass("ce-element--empty") : this._removeCSSClass("ce-element--empty")
			}, c.prototype._syncContent = function () {
				var a, b;
				return b = this.content.html(), this.content = new HTMLString.String(this._domElement.innerHTML, this.content.preserveWhitespace()), a = this.content.html(), b !== a && this.taint(), this._flagIfEmpty()
			}, c.droppers = {
				Static: a.Element._dropVert,
				Text: a.Element._dropVert
			}, c.mergers = {
				Text: function (a, b) {
					var c;
					return c = b.content.length(), a.content.length() && (b.content = b.content.concat(a.content)), b.isMounted() && b.updateInnerHTML(), b.focus(), new ContentSelect.Range(c, c).select(b._domElement), a.parent() && a.parent().detach(a), b.taint()
				}
			}, c.fromDOMElement = function (a) {
				return new this(a.tagName, this.getDOMElementAttributes(a), a.innerHTML.replace(/^\s+|\s+$/g, ""))
			}, c
		}(a.Element), a.TagNames.get().register(a.Text, "address", "blockquote", "h1", "h2", "h3", "h4", "h5", "h6", "p"), a.PreText = function (b) {
			function c(b, c, d) {
				this.content = d instanceof HTMLString.String ? d : new HTMLString.String(d, !0), a.Element.call(this, b, c)
			}
			return i(c, b), c.prototype.cssTypeName = function () {
				return "pre-text"
			}, c.prototype.type = function () {
				return "PreText"
			}, c.prototype.typeName = function () {
				return "Preformatted"
			}, c.prototype.blur = function () {
				return this.isMounted() && (this._domElement.innerHTML = this.content.html()), c.__super__.blur.call(this)
			}, c.prototype.html = function (a) {
				var b;
				return null == a && (a = ""), (!this._lastCached || this._lastCached < this._modified) && (b = this.content.copy(), b.optimize(), this._lastCached = Date.now(), this._cached = b.html()), "" + a + "<" + this._tagName + this._attributesToString() + ">" + ("" + this._cached + "</" + this._tagName + ">")
			}, c.prototype.updateInnerHTML = function () {
				var a;
				return a = this.content.html(), this._domElement.innerHTML = a, this._ensureEndZWS(), ContentSelect.Range.prepareElement(this._domElement), this._flagIfEmpty()
			}, c.prototype._keyBack = function (a) {
				var b;
				return b = ContentSelect.Range.query(this._domElement), b.get()[0] <= this.content.length() ? c.__super__._keyBack.call(this, a) : (b.set(this.content.length(), this.content.length()), b.select(this._domElement))
			}, c.prototype._keyReturn = function (a) {
				var b, c, d, e;
				return a.preventDefault(), c = ContentSelect.Range.query(this._domElement), b = c.get()[0] + 1, 0 === c.get()[0] && c.isCollapsed() ? this.content = new HTMLString.String("\n", !0).concat(this.content) : this._atEnd(c) && c.isCollapsed() ? this.content = this.content.concat(new HTMLString.String("\n", !0)) : 0 === c.get()[0] && c.get()[1] === this.content.length() ? (this.content = new HTMLString.String("\n", !0), b = 0) : (e = this.content.substring(0, c.get()[0]), d = this.content.substring(c.get()[1]), this.content = e.concat(new HTMLString.String("\n", !0), d)), this.updateInnerHTML(), c.set(b, b), c.select(this._domElement), this.taint()
			}, c.prototype._syncContent = function () {
				var a, b;
				return this._ensureEndZWS(), b = this.content.html(), this.content = new HTMLString.String(this._domElement.innerHTML.replace(/\u200B$/g, ""), this.content.preserveWhitespace()), a = this.content.html(), b !== a && this.taint(), this._flagIfEmpty()
			}, c.prototype._ensureEndZWS = function () {
				var a, b;
				if (this._domElement.lastChild && (a = this._domElement.innerHTML, !("​" === a[a.length - 1] && a.indexOf("​") < a.length - 1))) return b = function (b) {
					return function () {
						return a.indexOf("​") > -1 && (b._domElement.innerHTML = a.replace(/\u200B/g, "")), b._domElement.lastChild.textContent += "​"
					}
				}(this), this._savedSelection ? b() : (this.storeState(), b(), this.restoreState())
			}, c.droppers = {
				PreText: a.Element._dropVert,
				Static: a.Element._dropVert,
				Text: a.Element._dropVert
			}, c.mergers = {}, c.fromDOMElement = function (a) {
				return new this(a.tagName, this.getDOMElementAttributes(a), a.innerHTML)
			}, c
		}(a.Text), a.TagNames.get().register(a.PreText, "pre"), a.Image = function (b) {
			function c(a, b) {
				var d;
				c.__super__.constructor.call(this, "img", a), this.a = b ? b : null, d = this.size(), this._aspectRatio = d[1] / d[0]
			}
			return i(c, b), c.prototype.cssTypeName = function () {
				return "image"
			}, c.prototype.type = function () {
				return "Image"
			}, c.prototype.typeName = function () {
				return "Image"
			}, c.prototype.createDraggingDOMElement = function () {
				var a;
				if (this.isMounted()) return a = c.__super__.createDraggingDOMElement.call(this), a.style.backgroundImage = "url(" + this._attributes.src + ")", a
			}, c.prototype.html = function (b) {
				var c, d;
				return null == b && (b = ""), d = "" + b + "<img" + this._attributesToString() + ">", this.a ? (c = a.attributesToString(this.a), c = "" + c + ' data-ce-tag="img"', "" + b + "<a " + c + ">\n" + ("" + a.INDENT + d + "\n") + ("" + b + "</a>")) : d
			}, c.prototype.mount = function () {
				var a, b;
				return this._domElement = document.createElement("div"), a = "", this.a && this.a["class"] && (a += " " + this.a["class"]), this._attributes["class"] && (a += " " + this._attributes["class"]), this._domElement.setAttribute("class", a), b = this._attributes.style ? this._attributes.style : "", b += "background-image:url(" + this._attributes.src + ");", this._attributes.width && (b += "width:" + this._attributes.width + "px;"), this._attributes.height && (b += "height:" + this._attributes.height + "px;"), this._domElement.setAttribute("style", b), c.__super__.mount.call(this)
			}, c.prototype.unmount = function () {
				var a, b;
				return this.isFixed() && (b = document.createElement("div"), b.innerHTML = this.html(), a = b.querySelector("a, img"), this._domElement.parentNode.replaceChild(a, this._domElement), this._domElement = a), c.__super__.unmount.call(this)
			}, c.droppers = {
				Image: a.Element._dropBoth,
				PreText: a.Element._dropBoth,
				Static: a.Element._dropBoth,
				Text: a.Element._dropBoth
			}, c.placements = ["above", "below", "left", "right", "center"], c.fromDOMElement = function (a) {
				var b, c, d, e, f, g, h;
				if (b = null, "a" === a.tagName.toLowerCase()) {
					for (b = this.getDOMElementAttributes(a), f = function () {
							var b, c, e, f;
							for (e = a.childNodes, f = [], b = 0, c = e.length; c > b; b++) d = e[b], f.push(d);
							return f
						}(), g = 0, h = f.length; h > g; g++)
						if (e = f[g], 1 === e.nodeType && "img" === e.tagName.toLowerCase()) {
							a = e;
							break
						}
						"a" === a.tagName.toLowerCase() && (a = document.createElement("img"))
				}
				return c = this.getDOMElementAttributes(a), void 0 === c.width && (c.width = void 0 === c.height ? a.naturalWidth : a.clientWidth), void 0 === c.height && (c.height = void 0 === c.width ? a.naturalHeight : a.clientHeight), new this(c, b)
			}, c
		}(a.ResizableElement), a.TagNames.get().register(a.Image, "img"), a.Video = function (b) {
			function c(a, b, d) {
				var e;
				null == d && (d = []), c.__super__.constructor.call(this, a, b), this.sources = d, e = this.size(), this._aspectRatio = e[1] / e[0]
			}
			return i(c, b), c.prototype.cssTypeName = function () {
				return "video"
			}, c.prototype.type = function () {
				return "Video"
			}, c.prototype.typeName = function () {
				return "Video"
			}, c.prototype._title = function () {
				var a;
				return a = "", this.attr("src") ? a = this.attr("src") : this.sources.length && (a = this.sources[0].src), a || (a = "No video source set"), a.length > 80 && (a = a.substr(0, 80) + "..."), a
			}, c.prototype.createDraggingDOMElement = function () {
				var a;
				if (this.isMounted()) return a = c.__super__.createDraggingDOMElement.call(this), a.innerHTML = this._title(), a
			}, c.prototype.html = function (b) {
				var c, d, e, f, g, h;
				if (null == b && (b = ""), "video" === this.tagName()) {
					for (e = [], h = this.sources, f = 0, g = h.length; g > f; f++) d = h[f], c = a.attributesToString(d), e.push("" + b + a.INDENT + "<source " + c + ">");
					return "" + b + "<video" + this._attributesToString() + ">\n" + e.join("\n") + ("\n" + b + "</video>")
				}
				return "" + b + "<" + this._tagName + this._attributesToString() + ">" + ("</" + this._tagName + ">")
			}, c.prototype.mount = function () {
				var a;
				return this._domElement = document.createElement("div"), this.a && this.a["class"] ? this._domElement.setAttribute("class", this.a["class"]) : this._attributes["class"] && this._domElement.setAttribute("class", this._attributes["class"]), a = this._attributes.style ? this._attributes.style : "", this._attributes.width && (a += "width:" + this._attributes.width + "px;"), this._attributes.height && (a += "height:" + this._attributes.height + "px;"), this._domElement.setAttribute("style", a), this._domElement.setAttribute("data-ce-title", this._title()), c.__super__.mount.call(this)
			}, c.prototype.unmount = function () {
				var a, b;
				return this.isFixed() && (b = document.createElement("div"), b.innerHTML = this.html(), a = b.querySelector("iframe"), this._domElement.parentNode.replaceChild(a, this._domElement), this._domElement = a), c.__super__.unmount.call(this)
			}, c.droppers = {
				Image: a.Element._dropBoth,
				PreText: a.Element._dropBoth,
				Static: a.Element._dropBoth,
				Text: a.Element._dropBoth,
				Video: a.Element._dropBoth
			}, c.placements = ["above", "below", "left", "right", "center"], c.fromDOMElement = function (a) {
				var b, c, d, e, f, g;
				for (d = function () {
						var c, d, e, f;
						for (e = a.childNodes, f = [], c = 0, d = e.length; d > c; c++) b = e[c], f.push(b);
						return f
					}(), e = [], f = 0, g = d.length; g > f; f++) c = d[f], 1 === c.nodeType && "source" === c.tagName.toLowerCase() && e.push(this.getDOMElementAttributes(c));
				return new this(a.tagName, this.getDOMElementAttributes(a), e)
			}, c
		}(a.ResizableElement), a.TagNames.get().register(a.Video, "iframe", "video"), a.List = function (b) {
			function c(a, b) {
				c.__super__.constructor.call(this, a, b)
			}
			return i(c, b), c.prototype.cssTypeName = function () {
				return "list"
			}, c.prototype.type = function () {
				return "List"
			}, c.prototype.typeName = function () {
				return "List"
			}, c.prototype._onMouseOver = function (a) {
				return "ListItem" !== this.parent().type() ? (c.__super__._onMouseOver.call(this, a), this._removeCSSClass("ce-element--over")) : void 0
			}, c.droppers = {
				Image: a.Element._dropBoth,
				List: a.Element._dropVert,
				PreText: a.Element._dropVert,
				Static: a.Element._dropVert,
				Text: a.Element._dropVert,
				Video: a.Element._dropBoth
			}, c.fromDOMElement = function (b) {
				var c, d, e, f, g, h;
				for (f = new this(b.tagName, this.getDOMElementAttributes(b)), e = function () {
						var a, d, e, f;
						for (e = b.childNodes, f = [], a = 0, d = e.length; d > a; a++) c = e[a], f.push(c);
						return f
					}(), g = 0, h = e.length; h > g; g++) d = e[g], 1 === d.nodeType && "li" === d.tagName.toLowerCase() && f.attach(a.ListItem.fromDOMElement(d));
				return 0 === f.children.length ? null : f
			}, c
		}(a.ElementCollection), a.TagNames.get().register(a.List, "ol", "ul"), a.ListItem = function (b) {
			function c(a) {
				c.__super__.constructor.call(this, "li", a), this._behaviours.indent = !0
			}
			return i(c, b), c.prototype.cssTypeName = function () {
				return "list-item"
			}, c.prototype.list = function () {
				return 2 === this.children.length ? this.children[1] : null
			}, c.prototype.listItemText = function () {
				return this.children.length > 0 ? this.children[0] : null
			}, c.prototype.type = function () {
				return "ListItem"
			}, c.prototype.html = function (b) {
				var c;
				return null == b && (b = ""), c = ["" + b + "<li" + this._attributesToString() + ">"], this.listItemText() && c.push(this.listItemText().html(b + a.INDENT)), this.list() && c.push(this.list().html(b + a.INDENT)), c.push("" + b + "</li>"), c.join("\n")
			}, c.prototype.indent = function () {
				var b;
				if (this.can("indent") && 0 !== this.parent().children.indexOf(this)) return b = this.previousSibling(), b.list() || b.attach(new a.List(b.parent().tagName())), this.listItemText().storeState(), this.parent().detach(this), b.list().attach(this), this.listItemText().restoreState()
			}, c.prototype.remove = function () {
				var a, b, c, d, e, f;
				if (this.parent()) {
					if (c = this.parent().children.indexOf(this), this.list())
						for (f = this.list().children.slice(), b = d = 0, e = f.length; e > d; b = ++d) a = f[b], a.parent().detach(a), this.parent().attach(a, b + c);
					return this.parent().detach(this)
				}
			}, c.prototype.unindent = function () {
				var b, c, d, e, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, v;
				if (this.can("indent")) {
					if (g = this.parent(), c = g.parent(), k = g.children.slice(g.children.indexOf(this) + 1, g.children.length), "ListItem" === c.type()) {
						for (this.listItemText().storeState(), g.detach(this), c.parent().attach(this, c.parent().children.indexOf(c) + 1), k.length && !this.list() && this.attach(new a.List(g.tagName())), m = 0, q = k.length; q > m; m++) j = k[m], j.parent().detach(j), this.list().attach(j);
						return this.listItemText().restoreState()
					}
					if (l = new a.Text("p", this.attr("class") ? {
							"class": this.attr("class")
						} : {}, this.listItemText().content), i = null, this.listItemText().isFocused() && (i = ContentSelect.Range.query(this.listItemText().domElement())), h = c.children.indexOf(g), e = g.children.indexOf(this), 0 === e) {
						if (f = null, 1 === g.children.length ? (this.list() && (f = new a.List(g.tagName())), c.detach(g)) : g.detach(this), c.attach(l, h), f && c.attach(f, h + 1), this.list())
							for (u = this.list().children.slice(), d = n = 0, r = u.length; r > n; d = ++n) b = u[d], b.parent().detach(b), f ? f.attach(b) : g.attach(b, d)
					} else if (e === g.children.length - 1) g.detach(this), c.attach(l, h + 1), this.list() && c.attach(this.list(), h + 2);
					else {
						if (g.detach(this), c.attach(l, h + 1), f = new a.List(g.tagName()), c.attach(f, h + 2), this.list())
							for (v = this.list().children.slice(), o = 0, s = v.length; s > o; o++) b = v[o], b.parent().detach(b), f.attach(b);
						for (p = 0, t = k.length; t > p; p++) j = k[p], j.parent().detach(j), f.attach(j)
					}
					return i ? (l.focus(), i.select(l.domElement())) : void 0
				}
			}, c.prototype._onMouseOver = function (a) {
				return c.__super__._onMouseOver.call(this, a), this._removeCSSClass("ce-element--over")
			}, c.prototype._addDOMEventListeners = function () {}, c.prototype._removeDOMEventListners = function () {}, c.fromDOMElement = function (b) {
				var c, d, e, f, g, h, i, j, k, l;
				for (g = new this(this.getDOMElementAttributes(b)), d = "", e = null, k = b.childNodes, i = 0, j = k.length; j > i; i++) c = k[i], 1 === c.nodeType ? "ul" === (l = c.tagName.toLowerCase()) || "li" === l ? e || (e = c) : d += c.outerHTML : d += HTMLString.String.encode(c.textContent);
				return d = d.replace(/^\s+|\s+$/g, ""), h = new a.ListItemText(d), g.attach(h), e && (f = a.List.fromDOMElement(e), g.attach(f)), g
			}, c
		}(a.ElementCollection), a.ListItemText = function (b) {
			function c(a) {
				c.__super__.constructor.call(this, "div", {}, a)
			}
			return i(c, b), c.prototype.cssTypeName = function () {
				return "list-item-text"
			}, c.prototype.type = function () {
				return "ListItemText"
			}, c.prototype.typeName = function () {
				return "List item"
			}, c.prototype.blur = function () {
				return this.content.isWhitespace() && this.can("remove") ? this.parent().remove() : this.isMounted() && (this._domElement.blur(), this._domElement.removeAttribute("contenteditable")), a.Element.prototype.blur.call(this)
			}, c.prototype.can = function (a, b) {
				if (b) throw new Error("Cannot set behaviour for ListItemText");
				return this.parent().can(a)
			}, c.prototype.html = function (a) {
				var b;
				return null == a && (a = ""), (!this._lastCached || this._lastCached < this._modified) && (b = this.content.copy().trim(), b.optimize(), this._lastCached = Date.now(), this._cached = b.html()), "" + a + this._cached
			}, c.prototype._onMouseDown = function (b) {
				var c;
				return a.Element.prototype._onMouseDown.call(this, b), c = function (d) {
					return function () {
						var e;
						return a.Root.get().dragging() === d ? (a.Root.get().cancelDragging(), e = d.closest(function (a) {
							return "Region" === a.parent().type()
						}), e.drag(b.pageX, b.pageY)) : (d.drag(b.pageX, b.pageY), d._dragTimeout = setTimeout(c, 2 * a.DRAG_HOLD_DURATION))
					}
				}(this), clearTimeout(this._dragTimeout), this._dragTimeout = setTimeout(c, a.DRAG_HOLD_DURATION)
			}, c.prototype._onMouseMove = function (b) {
				return this._dragTimeout && clearTimeout(this._dragTimeout), a.Element.prototype._onMouseMove.call(this, b)
			}, c.prototype._onMouseUp = function (b) {
				return this._dragTimeout && clearTimeout(this._dragTimeout), a.Element.prototype._onMouseUp.call(this, b)
			}, c.prototype._keyTab = function (a) {
				return a.preventDefault(), a.shiftKey ? this.parent().unindent() : this.parent().indent()
			}, c.prototype._keyReturn = function (b) {
				var c, d, e, f, g, h;
				return b.preventDefault(), this.content.isWhitespace() ? void this.parent().unindent() : this.can("spawn") ? (ContentSelect.Range.query(this._domElement), f = ContentSelect.Range.query(this._domElement), h = this.content.substring(0, f.get()[0]), g = this.content.substring(f.get()[1]), h.length() + g.length() === 0 ? void this.parent().unindent() : (this.content = h.trim(), this.updateInnerHTML(), c = this.parent().parent(), e = new a.ListItem(this.attr("class") ? {
					"class": this.attr("class")
				} : {}), c.attach(e, c.children.indexOf(this.parent()) + 1), e.attach(new a.ListItemText(g.trim())), d = this.parent().list(), d && (this.parent().detach(d), e.attach(d)), h.length() ? (e.listItemText().focus(), f = new ContentSelect.Range(0, 0), f.select(e.listItemText().domElement())) : (f = new ContentSelect.Range(0, h.length()), f.select(this._domElement)), this.taint())) : void 0
			}, c.droppers = {
				ListItemText: function (b, c, d) {
					var e, f, g, h;
					return e = b.parent(), h = c.parent(), e.remove(), e.detach(b), g = new a.ListItem(e._attributes), g.attach(b), h.list() && "below" === d[0] ? void h.list().attach(g, 0) : (f = h.parent().children.indexOf(h), "below" === d[0] && (f += 1), h.parent().attach(g, f))
				},
				Text: function (b, c, d) {
					var e, f, g, h, i;
					if ("Text" === b.type()) {
						if (h = c.parent(), b.parent().detach(b), e = b.attr("class"), g = new a.ListItem(e ? {
								"class": e
							} : {}), g.attach(new a.ListItemText(b.content)), h.list() && "below" === d[0]) return void h.list().attach(g, 0);
						if (f = h.parent().children.indexOf(h), "below" === d[0] && (f += 1), h.parent().attach(g, f), g.listItemText().focus(), b._savedSelection) return b._savedSelection.select(g.listItemText().domElement())
					} else if (e = b.attr("class"), i = new a.Text("p", e ? {
							"class": e
						} : {}, b.content), b.parent().remove(), f = c.parent().children.indexOf(c), "below" === d[0] && (f += 1), c.parent().attach(i, f), i.focus(), b._savedSelection) return b._savedSelection.select(i.domElement())
				}
			}, c.mergers = {
				ListItemText: function (a, b) {
					var c;
					return c = b.content.length(), a.content.length() && (b.content = b.content.concat(a.content)), b.isMounted() && (b._domElement.innerHTML = b.content.html()), b.focus(), new ContentSelect.Range(c, c).select(b._domElement), "Text" === a.type() ? a.parent() && a.parent().detach(a) : a.parent().remove(), b.taint()
				}
			}, c
		}(a.Text), e = a.ListItemText.mergers, e.Text = e.ListItemText, a.Table = function (b) {
			function c(a) {
				c.__super__.constructor.call(this, "table", a)
			}
			return i(c, b), c.prototype.cssTypeName = function () {
				return "table"
			}, c.prototype.typeName = function () {
				return "Table"
			}, c.prototype.type = function () {
				return "Table"
			}, c.prototype.firstSection = function () {
				var a;
				return (a = this.thead()) ? a : (a = this.tbody()) ? a : (a = this.tfoot()) ? a : null
			}, c.prototype.lastSection = function () {
				var a;
				return (a = this.tfoot()) ? a : (a = this.tbody()) ? a : (a = this.thead()) ? a : null
			}, c.prototype.tbody = function () {
				return this._getChild("tbody")
			}, c.prototype.tfoot = function () {
				return this._getChild("tfoot")
			}, c.prototype.thead = function () {
				return this._getChild("thead")
			}, c.prototype._onMouseOver = function (a) {
				return c.__super__._onMouseOver.call(this, a), this._removeCSSClass("ce-element--over")
			}, c.prototype._getChild = function (a) {
				var b, c, d, e;
				for (e = this.children, c = 0, d = e.length; d > c; c++)
					if (b = e[c], b.tagName() === a) return b;
				return null
			}, c.droppers = {
				Image: a.Element._dropBoth,
				List: a.Element._dropVert,
				PreText: a.Element._dropVert,
				Static: a.Element._dropVert,
				Table: a.Element._dropVert,
				Text: a.Element._dropVert,
				Video: a.Element._dropBoth
			}, c.fromDOMElement = function (b) {
				var c, d, e, f, g, h, i, j, k, l, m, n;
				for (i = new this(this.getDOMElementAttributes(b)), e = function () {
						var a, d, e, f;
						for (e = b.childNodes, f = [], a = 0, d = e.length; d > a; a++) c = e[a], f.push(c);
						return f
					}(), f = [], k = 0, m = e.length; m > k; k++)
					if (d = e[k], 1 === d.nodeType && (j = d.tagName.toLowerCase(), !i._getChild(j))) switch (j) {
					case "tbody":
					case "tfoot":
					case "thead":
						h = a.TableSection.fromDOMElement(d), i.attach(h);
						break;
					case "tr":
						f.push(a.TableRow.fromDOMElement(d))
					}
					if (f.length > 0)
						for (i._getChild("tbody") || i.attach(new a.TableSection("tbody")), l = 0, n = f.length; n > l; l++) g = f[l], i.tbody().attach(g);
				return 0 === i.children.length ? null : i
			}, c
		}(a.ElementCollection), a.TagNames.get().register(a.Table, "table"), a.TableSection = function (b) {
			function c(a, b) {
				c.__super__.constructor.call(this, a, b)
			}
			return i(c, b), c.prototype.cssTypeName = function () {
				return "table-section"
			}, c.prototype.type = function () {
				return "TableSection"
			}, c.prototype._onMouseOver = function (a) {
				return c.__super__._onMouseOver.call(this, a), this._removeCSSClass("ce-element--over")
			}, c.fromDOMElement = function (b) {
				var c, d, e, f, g, h;
				for (f = new this(b.tagName, this.getDOMElementAttributes(b)), e = function () {
						var a, d, e, f;
						for (e = b.childNodes, f = [], a = 0, d = e.length; d > a; a++) c = e[a], f.push(c);
						return f
					}(), g = 0, h = e.length; h > g; g++) d = e[g], 1 === d.nodeType && "tr" === d.tagName.toLowerCase() && f.attach(a.TableRow.fromDOMElement(d));
				return f
			}, c
		}(a.ElementCollection), a.TableRow = function (b) {
			function c(a) {
				c.__super__.constructor.call(this, "tr", a)
			}
			return i(c, b), c.prototype.cssTypeName = function () {
				return "table-row"
			}, c.prototype.isEmpty = function () {
				var a, b, c, d, e;
				for (e = this.children, c = 0, d = e.length; d > c; c++)
					if (a = e[c], b = a.tableCellText(), b && b.content.length() > 0) return !1;
				return !0
			}, c.prototype.type = function () {
				return "TableRow"
			}, c.prototype.typeName = function () {
				return "Table row"
			}, c.prototype._onMouseOver = function (a) {
				return c.__super__._onMouseOver.call(this, a), this._removeCSSClass("ce-element--over")
			}, c.droppers = {
				TableRow: a.Element._dropVert
			}, c.fromDOMElement = function (b) {
				var c, d, e, f, g, h, i;
				for (f = new this(this.getDOMElementAttributes(b)), e = function () {
						var a, d, e, f;
						for (e = b.childNodes, f = [], a = 0, d = e.length; d > a; a++) c = e[a], f.push(c);
						return f
					}(), h = 0, i = e.length; i > h; h++) d = e[h], 1 === d.nodeType && (g = d.tagName.toLowerCase(), ("td" === g || "th" === g) && f.attach(a.TableCell.fromDOMElement(d)));
				return f
			}, c
		}(a.ElementCollection), a.TableCell = function (b) {
			function c(a, b) {
				c.__super__.constructor.call(this, a, b)
			}
			return i(c, b), c.prototype.cssTypeName = function () {
				return "table-cell"
			}, c.prototype.tableCellText = function () {
				return this.children.length > 0 ? this.children[0] : null
			}, c.prototype.type = function () {
				return "TableCell"
			}, c.prototype.html = function (b) {
				var c;
				return null == b && (b = ""), c = ["" + b + "<" + this.tagName() + this._attributesToString() + ">"], this.tableCellText() && c.push(this.tableCellText().html(b + a.INDENT)), c.push("" + b + "</" + this.tagName() + ">"), c.join("\n")
			}, c.prototype._onMouseOver = function (a) {
				return c.__super__._onMouseOver.call(this, a), this._removeCSSClass("ce-element--over")
			}, c.prototype._addDOMEventListeners = function () {}, c.prototype._removeDOMEventListners = function () {}, c.fromDOMElement = function (b) {
				var c, d;
				return c = new this(b.tagName, this.getDOMElementAttributes(b)), d = new a.TableCellText(b.innerHTML.replace(/^\s+|\s+$/g, "")), c.attach(d), c
			}, c
		}(a.ElementCollection), a.TableCellText = function (b) {
			function c(a) {
				c.__super__.constructor.call(this, "div", {}, a)
			}
			return i(c, b), c.prototype.cssTypeName = function () {
				return "table-cell-text"
			}, c.prototype.type = function () {
				return "TableCellText"
			}, c.prototype._isInFirstRow = function () {
				var a, b, c, d;
				return a = this.parent(), b = a.parent(), c = b.parent(), d = c.parent(), c !== d.firstSection() ? !1 : b === c.children[0]
			}, c.prototype._isInLastRow = function () {
				var a, b, c, d;
				return a = this.parent(), b = a.parent(), c = b.parent(), d = c.parent(), c !== d.lastSection() ? !1 : b === c.children[c.children.length - 1]
			}, c.prototype._isLastInSection = function () {
				var a, b, c;
				return a = this.parent(), b = a.parent(), c = b.parent(), b !== c.children[c.children.length - 1] ? !1 : a === b.children[b.children.length - 1]
			}, c.prototype.blur = function () {
				return this.isMounted() && (this._domElement.blur(), this._domElement.removeAttribute("contenteditable")), a.Element.prototype.blur.call(this)
			}, c.prototype.can = function (a, b) {
				if (b) throw new Error("Cannot set behaviour for ListItemText");
				return this.parent().can(a)
			}, c.prototype.html = function (a) {
				var b;
				return null == a && (a = ""), (!this._lastCached || this._lastCached < this._modified) && (b = this.content.copy().trim(), b.optimize(), this._lastCached = Date.now(), this._cached = b.html()), "" + a + this._cached
			}, c.prototype._onMouseDown = function (b) {
				var c;
				return a.Element.prototype._onMouseDown.call(this, b), c = function (d) {
					return function () {
						var e, f;
						return e = d.parent(), a.Root.get().dragging() === e.parent() ? (a.Root.get().cancelDragging(), f = e.parent().parent().parent(), f.drag(b.pageX, b.pageY)) : (e.parent().drag(b.pageX, b.pageY), d._dragTimeout = setTimeout(c, 2 * a.DRAG_HOLD_DURATION))
					}
				}(this), clearTimeout(this._dragTimeout), this._dragTimeout = setTimeout(c, a.DRAG_HOLD_DURATION)
			}, c.prototype._keyBack = function (a) {
				var b, c, d, e;
				return e = ContentSelect.Range.query(this._domElement), 0 === e.get()[0] && e.isCollapsed() && (a.preventDefault(), b = this.parent(), d = b.parent(), d.isEmpty() && d.can("remove")) && 0 === this.content.length() && 0 === d.children.indexOf(b) ? (c = this.previousContent(), c && (c.focus(), e = new ContentSelect.Range(c.content.length(), c.content.length()), e.select(c.domElement())), d.parent().detach(d)) : void 0
			}, c.prototype._keyDelete = function (a) {
				var b, c, d, e;
				return d = this.parent().parent(), d.isEmpty() && d.can("remove") ? (a.preventDefault(), b = d.children[d.children.length - 1], c = b.tableCellText().nextContent(), c && (c.focus(), e = new ContentSelect.Range(0, 0), e.select(c.domElement())), d.parent().detach(d)) : void 0
			}, c.prototype._keyDown = function (b) {
				var c, d, e, f, g, h, i;
				return i = ContentSelect.Range.query(this._domElement), this._atEnd(i) && i.isCollapsed() ? (b.preventDefault(), c = this.parent(), this._isInLastRow() ? (h = c.parent(), e = h.children[h.children.length - 1].tableCellText(), f = e.nextContent(), f ? f.focus() : a.Root.get().trigger("next-region", this.closest(function (a) {
					return "Fixture" === a.type() || "Region" === a.type()
				}))) : (g = c.parent().nextWithTest(function (a) {
					return "TableRow" === a.type()
				}), d = c.parent().children.indexOf(c), d = Math.min(d, g.children.length), g.children[d].tableCellText().focus())) : void 0
			}, c.prototype._keyReturn = function (a) {
				return a.preventDefault(), this._keyTab({
					shiftKey: !1,
					preventDefault: function () {}
				})
			}, c.prototype._keyTab = function (b) {
				var c, d, e, f, g, h, i, j, k, l;
				if (b.preventDefault(), c = this.parent(), b.shiftKey) {
					if (this._isInFirstRow() && c.parent().children[0] === c) return;
					return this.previousContent().focus()
				}
				if (this.can("spawn")) {
					if (e = c.parent().parent(), "tbody" === e.tagName() && this._isLastInSection()) {
						for (h = new a.TableRow, l = c.parent().children, j = 0, k = l.length; k > j; j++) d = l[j], f = new a.TableCell(d.tagName(), d._attributes), g = new a.TableCellText(""), f.attach(g), h.attach(f);
						return i = this.closest(function (a) {
							return "TableSection" === a.type()
						}), i.attach(h), h.children[0].tableCellText().focus()
					}
					return this.nextContent().focus()
				}
			}, c.prototype._keyUp = function (b) {
				var c, d, e, f, g, h;
				return h = ContentSelect.Range.query(this._domElement), 0 === h.get()[0] && h.isCollapsed() ? (b.preventDefault(), c = this.parent(), this._isInFirstRow() ? (g = c.parent(), e = g.children[0].previousContent(), e ? e.focus() : a.Root.get().trigger("previous-region", this.closest(function (a) {
					return "Fixture" === a.type() || "Region" === a.type()
				}))) : (f = c.parent().previousWithTest(function (a) {
					return "TableRow" === a.type()
				}), d = c.parent().children.indexOf(c), d = Math.min(d, f.children.length), f.children[d].tableCellText().focus())) : void 0
			}, c.droppers = {}, c.mergers = {}, c
		}(a.Text)
	}.call(this),
	function () {
		var a, b, c, d, e, f, g = {}.hasOwnProperty,
			h = function (a, b) {
				function c() {
					this.constructor = a
				}
				for (var d in b) g.call(b, d) && (a[d] = b[d]);
				return c.prototype = b.prototype, a.prototype = new c, a.__super__ = b.prototype, a
			},
			i = function (a, b) {
				return function () {
					return a.apply(b, arguments)
				}
			},
			j = [].slice;
		b = {
			Tools: {},
			CANCEL_MESSAGE: "Your changes have not been saved, do you really want to lose them?".trim(),
			DEFAULT_TOOLS: [["bold", "italic", "link", "align-left", "align-center", "align-right"], ["heading", "subheading", "paragraph", "unordered-list", "ordered-list", "table", "indent", "unindent", "line-break"], ["image", "video", "preformatted"], ["undo", "redo", "remove"]],
			DEFAULT_VIDEO_HEIGHT: 300,
			DEFAULT_VIDEO_WIDTH: 400,
			HIGHLIGHT_HOLD_DURATION: 2e3,
			INSPECTOR_IGNORED_ELEMENTS: ["Fixture", "ListItemText", "Region", "TableCellText"],
			IMAGE_UPLOADER: null,
			MIN_CROP: 10,
			RESTRICTED_ATTRIBUTES: {
				"*": ["style"],
				img: ["height", "src", "width", "data-ce-max-width", "data-ce-min-width"],
				iframe: ["height", "width"]
			},
			getEmbedVideoURL: function (a) {
				var b, c, d, e, f, g, h, i, j, k, l, m, n, o, p;
				for (b = {
						"www.youtube.com": "youtube",
						"youtu.be": "youtube",
						"vimeo.com": "vimeo",
						"player.vimeo.com": "vimeo"
					}, k = document.createElement("a"), k.href = a, g = k.hostname.toLowerCase(), l = k.pathname, null !== l && "/" !== l.substr(0, 1) && (l = "/" + l), i = {}, j = k.search.slice(1), p = j.split("&"), n = 0, o = p.length; o > n; n++) e = p[n], e = e.split("="), e[0] && (i[e[0]] = e[1]);
				switch (b[g]) {
				case "youtube":
					if ("/watch" === l.toLowerCase()) {
						if (!i.v) return null;
						c = i.v, delete i.v
					} else {
						if (f = l.match(/\/([A-Za-z0-9_-]+)$/i), !f) return null;
						c = f[1]
					}
					return a = "https://www.youtube.com/embed/" + c, h = function () {
						var a;
						a = [];
						for (d in i) m = i[d], a.push("" + d + "=" + m);
						return a
					}().join("&"), h && (a += "?" + h), a;
				case "vimeo":
					return (f = l.match(/\/(\w+\/\w+\/){0,1}(\d+)/i)) ? (a = "https://player.vimeo.com/video/" + f[2], h = function () {
						var a;
						a = [];
						for (d in i) m = i[d], a.push("" + d + "=" + m);
						return a
					}().join("&"), h && (a += "?" + h), a) : null
				}
				return null
			},
			getRestrictedAtributes: function (a) {
				var c;
				return c = [], b.RESTRICTED_ATTRIBUTES[a] && (c = c.concat(b.RESTRICTED_ATTRIBUTES[a])), b.RESTRICTED_ATTRIBUTES["*"] && (c = c.concat(b.RESTRICTED_ATTRIBUTES["*"])), c
			},
			getScrollPosition: function () {
				var a, b;
				return b = void 0 !== window.pageXOffset, a = 4 === (document.compatMode || 4), b ? [window.pageXOffset, window.pageYOffset] : a ? [document.documentElement.scrollLeft, document.documentElement.scrollTop] : [document.body.scrollLeft, document.body.scrollTop]
			}
		}, "undefined" != typeof window && (window.ContentTools = b), "undefined" != typeof module && module.exports && (e = module.exports = b), b.ComponentUI = function () {
			function a() {
				this._bindings = {}, this._parent = null, this._children = [], this._domElement = null
			}
			return a.prototype.children = function () {
				return this._children.slice()
			}, a.prototype.domElement = function () {
				return this._domElement
			}, a.prototype.isMounted = function () {
				return null !== this._domElement
			}, a.prototype.parent = function () {
				return this._parent
			}, a.prototype.attach = function (a, b) {
				return a.parent() && a.parent().detach(a), a._parent = this, void 0 !== b ? this._children.splice(b, 0, a) : this._children.push(a)
			}, a.prototype.addCSSClass = function (a) {
				return this.isMounted() ? ContentEdit.addCSSClass(this._domElement, a) : void 0
			}, a.prototype.detatch = function (a) {
				var b;
				return b = this._children.indexOf(a), -1 !== b ? this._children.splice(b, 1) : void 0
			}, a.prototype.mount = function () {}, a.prototype.removeCSSClass = function (a) {
				return this.isMounted() ? ContentEdit.removeCSSClass(this._domElement, a) : void 0
			}, a.prototype.unmount = function () {
				return this.isMounted() ? (this._removeDOMEventListeners(), this._domElement.parentNode && this._domElement.parentNode.removeChild(this._domElement), this._domElement = null) : void 0
			}, a.prototype.addEventListener = function (a, b) {
				void 0 === this._bindings[a] && (this._bindings[a] = []), this._bindings[a].push(b)
			}, a.prototype.createEvent = function (a, c) {
				return new b.Event(a, c)
			}, a.prototype.dispatchEvent = function (a) {
				var b, c, d, e;
				if (!this._bindings[a.name()]) return !a.defaultPrevented();
				for (e = this._bindings[a.name()], c = 0, d = e.length; d > c && (b = e[c], !a.propagationStopped()); c++) b && b.call(this, a);
				return !a.defaultPrevented()
			}, a.prototype.removeEventListener = function (a, b) {
				var c, d, e, f, g, h;
				if (!a) return void(this._bindings = {});
				if (!b) return void(this._bindings[a] = void 0);
				if (this._bindings[a]) {
					for (g = this._bindings[a], h = [], c = e = 0, f = g.length; f > e; c = ++e) d = g[c], h.push(d === b ? this._bindings[a].splice(c, 1) : void 0);
					return h
				}
			}, a.prototype._addDOMEventListeners = function () {}, a.prototype._removeDOMEventListeners = function () {}, a.createDiv = function (a, b, c) {
				var d, e, f;
				if (d = document.createElement("div"), a && a.length > 0 && d.setAttribute("class", a.join(" ")), b)
					for (e in b) f = b[e], d.setAttribute(e, f);
				return c && (d.innerHTML = c), d
			}, a
		}(), b.WidgetUI = function (a) {
			function b() {
				return b.__super__.constructor.apply(this, arguments)
			}
			return h(b, a), b.prototype.attach = function (a, c) {
				return b.__super__.attach.call(this, a, c), this.isMounted() ? void 0 : a.mount()
			}, b.prototype.detatch = function (a) {
				return b.__super__.detatch.call(this, a), this.isMounted() ? a.unmount() : void 0
			}, b.prototype.show = function () {
				var a;
				return this.isMounted() || this.mount(), a = function (a) {
					return function () {
						return a.addCSSClass("ct-widget--active")
					}
				}(this), setTimeout(a, 100)
			}, b.prototype.hide = function () {
				var a;
				return this.removeCSSClass("ct-widget--active"), a = function (b) {
					return function () {
						return window.getComputedStyle ? parseFloat(window.getComputedStyle(b._domElement).opacity) < .01 ? b.unmount() : setTimeout(a, 250) : void b.unmount()
					}
				}(this), this.isMounted() ? setTimeout(a, 250) : void 0
			}, b
		}(b.ComponentUI), b.AnchoredComponentUI = function (a) {
			function b() {
				return b.__super__.constructor.apply(this, arguments)
			}
			return h(b, a), b.prototype.mount = function (a, b) {
				return null == b && (b = null), a.insertBefore(this._domElement, b), this._addDOMEventListeners()
			}, b
		}(b.ComponentUI), b.Event = function () {
			function a(a, b) {
				this._name = a, this._detail = b, this._timeStamp = Date.now(), this._defaultPrevented = !1, this._propagationStopped = !1
			}
			return a.prototype.defaultPrevented = function () {
				return this._defaultPrevented
			}, a.prototype.detail = function () {
				return this._detail
			}, a.prototype.name = function () {
				return this._name
			}, a.prototype.propagationStopped = function () {
				return this._propagationStopped
			}, a.prototype.timeStamp = function () {
				return this._timeStamp
			}, a.prototype.preventDefault = function () {
				return this._defaultPrevented = !0
			}, a.prototype.stopImmediatePropagation = function () {
				return this._propagationStopped = !0
			}, a
		}(), b.FlashUI = function (a) {
			function c(a) {
				c.__super__.constructor.call(this), this.mount(a)
			}
			return h(c, a), c.prototype.mount = function (a) {
				var d;
				return this._domElement = this.constructor.createDiv(["ct-flash", "ct-flash--active", "ct-flash--" + a, "ct-widget", "ct-widget--active"]), c.__super__.mount.call(this, b.EditorApp.get().domElement()), d = function (a) {
					return function () {
						return window.getComputedStyle ? parseFloat(window.getComputedStyle(a._domElement).opacity) < .01 ? a.unmount() : setTimeout(d, 250) : void a.unmount()
					}
				}(this), setTimeout(d, 250)
			}, c
		}(b.AnchoredComponentUI), b.IgnitionUI = function (a) {
			function b() {
				b.__super__.constructor.call(this), this._revertToState = "ready", this._state = "ready"
			}
			return h(b, a), b.prototype.busy = function (a) {
				if (this.dispatchEvent(this.createEvent("busy", {
						busy: a
					}))) {
					if (a === ("busy" === this._state)) return;
					return a ? (this._revertToState = this._state, this.state("busy")) : this.state(this._revertToState)
				}
			}, b.prototype.cancel = function () {
				return this.dispatchEvent(this.createEvent("cancel")) ? this.state("ready") : void 0
			}, b.prototype.confirm = function () {
				return this.dispatchEvent(this.createEvent("confirm")) ? this.state("ready") : void 0
			}, b.prototype.edit = function () {
				return this.dispatchEvent(this.createEvent("edit")) ? this.state("editing") : void 0
			}, b.prototype.mount = function () {
				return b.__super__.mount.call(this), this._domElement = this.constructor.createDiv(["ct-widget", "ct-ignition", "ct-ignition--ready"]), this.parent().domElement().appendChild(this._domElement), this._domEdit = this.constructor.createDiv(["ct-ignition__button", "ct-ignition__button--edit"]), this._domElement.appendChild(this._domEdit), this._domConfirm = this.constructor.createDiv(["ct-ignition__button", "ct-ignition__button--confirm"]), this._domElement.appendChild(this._domConfirm), this._domCancel = this.constructor.createDiv(["ct-ignition__button", "ct-ignition__button--cancel"]), this._domElement.appendChild(this._domCancel), this._domBusy = this.constructor.createDiv(["ct-ignition__button", "ct-ignition__button--busy"]), this._domElement.appendChild(this._domBusy), this._addDOMEventListeners()
			}, b.prototype.state = function (a) {
				if (void 0 === a) return this._state;
				if (this._state !== a && this.dispatchEvent(this.createEvent("statechange", {
						state: a
					}))) return this._state = a, this.removeCSSClass("ct-ignition--busy"), this.removeCSSClass("ct-ignition--editing"), this.removeCSSClass("ct-ignition--ready"), "busy" === this._state ? this.addCSSClass("ct-ignition--busy") : "editing" === this._state ? this.addCSSClass("ct-ignition--editing") : "ready" === this._state ? this.addCSSClass("ct-ignition--ready") : void 0
			}, b.prototype.unmount = function () {
				return b.__super__.unmount.call(this), this._domEdit = null, this._domConfirm = null, this._domCancel = null
			}, b.prototype._addDOMEventListeners = function () {
				return this._domEdit.addEventListener("click", function (a) {
					return function (b) {
						return b.preventDefault(), a.edit()
					}
				}(this)), this._domConfirm.addEventListener("click", function (a) {
					return function (b) {
						return b.preventDefault(), a.confirm()
					}
				}(this)), this._domCancel.addEventListener("click", function (a) {
					return function (b) {
						return b.preventDefault(), a.cancel()
					}
				}(this))
			}, b
		}(b.WidgetUI), b.InspectorUI = function (a) {
			function c() {
				c.__super__.constructor.call(this), this._tagUIs = []
			}
			return h(c, a), c.prototype.mount = function () {
				return this._domElement = this.constructor.createDiv(["ct-widget", "ct-inspector"]), this.parent().domElement().appendChild(this._domElement), /* CHANGED HERE: commented out -> this._domTags = this.constructor.createDiv(["ct-inspector__tags", "ct-tags"]), this._domElement.appendChild(this._domTags),*/ this._domCounter = this.constructor.createDiv(["ct-inspector__counter"]), this._domElement.appendChild(this._domCounter), this.updateCounter(), this._addDOMEventListeners(), this._handleFocusChange = function (a) {
					return function () {
						return a.updateTags()
					}
				}(this), ContentEdit.Root.get().bind("blur", this._handleFocusChange), ContentEdit.Root.get().bind("focus", this._handleFocusChange), ContentEdit.Root.get().bind("mount", this._handleFocusChange)
			}, c.prototype.unmount = function () {
				return c.__super__.unmount.call(this), this._domTags = null, ContentEdit.Root.get().unbind("blur", this._handleFocusChange), ContentEdit.Root.get().unbind("focus", this._handleFocusChange), ContentEdit.Root.get().unbind("mount", this._handleFocusChange)
			}, c.prototype.updateCounter = function () {
				var a, c, d, e, f, g, h, i, j, k, l;
				if (this.isMounted()) {
					for (c = "", l = b.EditorApp.get().orderedRegions(), j = 0, k = l.length; k > j; j++) g = l[j], g && (c += g.domElement().textContent);
					return c = c.trim(), c = c.replace(/<\/?[a-z][^>]*>/gi, ""), c = c.replace(/[\u200B]+/, ""), c = c.replace(/['";:,.?¿\-!¡]+/g, ""), i = (c.match(/\S+/g) || []).length, i = i.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","), d = ContentEdit.Root.get().focused(), d && "PreText" === d.type() && d.selection().isCollapsed() ? (e = 0, a = 1, h = d.content.substring(0, d.selection().get()[0]), f = h.text().split("\n"), e = f.length, a = f[f.length - 1].length + 1, e = e.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","), a = a.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","), this._domCounter.textContent = "" + i + " / " + e + ":" + a) : void(this._domCounter.textContent = i + ' words' /* CHANGED HERE: Added 'words' */)
				}
			}, c.prototype.updateTags = function () {
				var a, c, d, e, f, g, h, i, j;
				for (a = ContentEdit.Root.get().focused(), i = this._tagUIs, e = 0, g = i.length; g > e; e++) d = i[e], d.unmount();
				if (this._tagUIs = [], a) {
					for (c = a.parents(), c.reverse(), c.push(a), j = [], f = 0, h = c.length; h > f; f++) a = c[f], -1 === b.INSPECTOR_IGNORED_ELEMENTS.indexOf(a.type()) && (a.isFixed() || (d = new b.TagUI(a), this._tagUIs.push(d), j.push(d.mount(this._domTags))));
					return j
				}
			}, c.prototype._addDOMEventListeners = function () {
				return this._updateCounterInterval = setInterval(function (a) {
					return function () {
						return a.updateCounter()
					}
				}(this), 250)
			}, c.prototype._removeDOMEventListeners = function () {
				return clearInterval(this._updateCounterInterval)
			}, c
		}(b.WidgetUI), b.TagUI = function (a) {
			function c(a) {
				this.element = a, this._onMouseDown = i(this._onMouseDown, this), c.__super__.constructor.call(this)
			}
			return h(c, a), c.prototype.mount = function (a, b) {
				return null == b && (b = null)/* CHANGED HERE: commented out -> , this._domElement = this.constructor.createDiv(["ct-tag"]), this._domElement.textContent = this.element.tagName(), c.__super__.mount.call(this, a, b)*/
			}, c.prototype._addDOMEventListeners = function () {
				return this._domElement.addEventListener("mousedown", this._onMouseDown)
			}, c.prototype._onMouseDown = function (a) {
				var c, d, e;
				return a.preventDefault(), this.element.storeState && this.element.storeState(), c = b.EditorApp.get(), e = new b.ModalUI, d = new b.PropertiesDialog(this.element), d.addEventListener("cancel", function (a) {
					return function () {
						return e.hide(), d.hide(), a.element.restoreState ? a.element.restoreState() : void 0
					}
				}(this)), d.addEventListener("save", function (a) {
					return function (b) {
						var c, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u;
						j = b.detail(), f = j.changedAttributes, n = j.changedStyles, l = j.innerHTML;
						for (m in f)
							if (o = f[m], "class" === m) {
								for (null === o && (o = ""), h = {}, t = o.split(" "), p = 0, r = t.length; r > p; p++) g = t[p], g = g.trim(), g && (h[g] = !0, a.element.hasCSSClass(g) || a.element.addCSSClass(g));
								for (u = a.element.attr("class").split(" "), q = 0, s = u.length; s > q; q++) g = u[q], g = g.trim(), void 0 === h[g] && a.element.removeCSSClass(g)
							} else null === o ? a.element.removeAttr(m) : a.element.attr(m, o);
						for (i in n) c = n[i], c ? a.element.addCSSClass(i) : a.element.removeCSSClass(i);
						return null !== l && l !== d.getElementInnerHTML() && (k = a.element, k.content || (k = k.children[0]), k.content = new HTMLString.String(l, k.content.preserveWhitespace()), k.updateInnerHTML(), k.taint(), k.selection(new ContentSelect.Range(0, 0)), k.storeState()), e.hide(), d.hide(), a.element.restoreState ? a.element.restoreState() : void 0
					}
				}(this)), c.attach(e), c.attach(d), e.show(), d.show()
			}, c
		}(b.AnchoredComponentUI), b.ModalUI = function (a) {
			function b(a, c) {
				b.__super__.constructor.call(this), this._transparent = a, this._allowScrolling = c
			}
			return h(b, a), b.prototype.mount = function () {
				return this._domElement = this.constructor.createDiv(["ct-widget", "ct-modal"]), this.parent().domElement().appendChild(this._domElement), this._transparent && this.addCSSClass("ct-modal--transparent"), this._allowScrolling || ContentEdit.addCSSClass(document.body, "ct--no-scroll"), this._addDOMEventListeners()
			}, b.prototype.unmount = function () {
				return this._allowScrolling || ContentEdit.removeCSSClass(document.body, "ct--no-scroll"), b.__super__.unmount.call(this)
			}, b.prototype._addDOMEventListeners = function () {
				return this._domElement.addEventListener("click", function (a) {
					return function () {
						return a.dispatchEvent(a.createEvent("click"))
					}
				}(this))
			}, b
		}(b.WidgetUI), b.ToolboxUI = function (a) {
			function c(a) {
				this._onStopDragging = i(this._onStopDragging, this), this._onStartDragging = i(this._onStartDragging, this), this._onDrag = i(this._onDrag, this), c.__super__.constructor.call(this), this._tools = a, this._dragging = !1, this._draggingOffset = null, this._domGrip = null, this._toolUIs = {}
			}
			return h(c, a), c.prototype.isDragging = function () {
				return this._dragging
			}, c.prototype.hide = function () {
				return this._removeDOMEventListeners(), c.__super__.hide.call(this)
			}, c.prototype.mount = function () {
				var a, b, c;
				return this._domElement = this.constructor.createDiv(["ct-widget", "ct-toolbox"]), this.parent().domElement().appendChild(this._domElement), this._domGrip = this.constructor.createDiv(["ct-toolbox__grip", "ct-grip"]), this._domElement.appendChild(this._domGrip), this._domGrip.appendChild(this.constructor.createDiv(["ct-grip__bump"])), this._domGrip.appendChild(this.constructor.createDiv(["ct-grip__bump"])), this._domGrip.appendChild(this.constructor.createDiv(["ct-grip__bump"])), this._domToolGroups = this.constructor.createDiv(["ct-tool-groups"]), this._domElement.appendChild(this._domToolGroups), this.tools(this._tools), c = window.localStorage.getItem("ct-toolbox-position"), c && /^\d+,\d+$/.test(c) && (b = function () {
					var b, d, e, f;
					for (e = c.split(","), f = [], b = 0, d = e.length; d > b; b++) a = e[b], f.push(parseInt(a));
					return f
				}(), this._domElement.style.left = "" + b[0] + "px", this._domElement.style.top = "" + b[1] + "px", this._contain()), this._addDOMEventListeners()
			}, c.prototype.tools = function (a) {
				var c, d, e, f, g, h, i, j, k, l, m;
				if (void 0 === a) return this._tools;
				if (this._tools = a, this.isMounted()) {
					k = this._toolUIs;
					for (g in k) h = k[g], h.unmount();
					for (this._toolUIs = {}; this._domToolGroups.lastChild;) this._domToolGroups.removeChild(this._domToolGroups.lastChild);
					for (l = this._tools, m = [], d = i = 0, j = l.length; j > i; d = ++i) f = l[d], c = this.constructor.createDiv(["ct-tool-group"]), this._domToolGroups.appendChild(c), m.push(function () {
						var a, d, h;
						for (h = [], a = 0, d = f.length; d > a; a++) g = f[a], e = b.ToolShelf.fetch(g), this._toolUIs[g] = new b.ToolUI(e), this._toolUIs[g].mount(c), this._toolUIs[g].disabled(!0), h.push(this._toolUIs[g].addEventListener("applied", function (a) {
							return function () {
								return a.updateTools()
							}
						}(this)));
						return h
					}.call(this));
					return m
				}
			}, c.prototype.updateTools = function () {
				var a, b, c, d, e, f;
				a = ContentEdit.Root.get().focused(), c = null, a && a.selection && (c = a.selection()), e = this._toolUIs, f = [];
				for (b in e) d = e[b], f.push(d.update(a, c));
				return f
			}, c.prototype.unmount = function () {
				return c.__super__.unmount.call(this), this._domGrip = null
			}, c.prototype._addDOMEventListeners = function () {
				return this._domGrip.addEventListener("mousedown", this._onStartDragging), this._handleResize = function (a) {
					return function () {
						var b;
						return a._resizeTimeout && clearTimeout(a._resizeTimeout), b = function () {
							return a._contain()
						}, a._resizeTimeout = setTimeout(b, 250)
					}
				}(this), window.addEventListener("resize", this._handleResize), this._updateTools = function (a) {
					return function () {
						var c, d, e, f, g, h, i, j;
						if (c = b.EditorApp.get(), h = !1, d = ContentEdit.Root.get().focused(), f = null, d === a._lastUpdateElement ? d && d.selection && (f = d.selection(), a._lastUpdateSelection ? f.eq(a._lastUpdateSelection) || (h = !0) : h = !0) : h = !0, c.history && (a._lastUpdateHistoryLength !== c.history.length() && (h = !0), a._lastUpdateHistoryLength = c.history.length(), a._lastUpdateHistoryIndex !== c.history.index() && (h = !0), a._lastUpdateHistoryIndex = c.history.index()), a._lastUpdateElement = d, a._lastUpdateSelection = f, h) {
							i = a._toolUIs, j = [];
							for (e in i) g = i[e], j.push(g.update(d, f));
							return j
						}
					}
				}(this), this._updateToolsInterval = setInterval(this._updateTools, 100), this._handleKeyDown = function () {
					return function (a) {
						var c, d, e, f, g, h;
						if (d = ContentEdit.Root.get().focused(), d && !d.content) {
							if (46 === a.keyCode) return a.preventDefault(), b.Tools.Remove.apply(d, null, function () {});
							if (13 === a.keyCode) return a.preventDefault(), c = b.Tools.Paragraph, c.apply(d, null, function () {})
						}
						switch (h = navigator.appVersion, e = "linux", -1 !== h.indexOf("Mac") ? e = "mac" : -1 !== h.indexOf("Win") && (e = "windows"), f = !1, g = !1, e) {
						case "linux":
							90 === a.keyCode && a.ctrlKey && (f = a.shiftKey, g = !f);
							break;
						case "mac":
							90 === a.keyCode && a.metaKey && (f = a.shiftKey, g = !f);
							break;
						case "windows":
							89 === a.keyCode && a.ctrlKey && (f = !0), 90 === a.keyCode && a.ctrlKey && (g = !0)
						}
						return g && b.Tools.Undo.canApply(null, null) && b.Tools.Undo.apply(null, null, function () {}), f && b.Tools.Redo.canApply(null, null) ? b.Tools.Redo.apply(null, null, function () {}) : void 0
					}
				}(this), window.addEventListener("keydown", this._handleKeyDown)
			}, c.prototype._contain = function () {
				var a;
				if (this.isMounted()) return a = this._domElement.getBoundingClientRect(), a.left + a.width > window.innerWidth && (this._domElement.style.left = "" + (window.innerWidth - a.width) + "px"), a.top + a.height > window.innerHeight && (this._domElement.style.top = "" + (window.innerHeight - a.height) + "px"), a.left < 0 && (this._domElement.style.left = "0px"), a.top < 0 && (this._domElement.style.top = "0px"), a = this._domElement.getBoundingClientRect(), window.localStorage.setItem("ct-toolbox-position", "" + a.left + "," + a.top)
			}, c.prototype._removeDOMEventListeners = function () {
				return this.isMounted() && this._domGrip.removeEventListener("mousedown", this._onStartDragging), window.removeEventListener("keydown", this._handleKeyDown), window.removeEventListener("resize", this._handleResize), clearInterval(this._updateToolsInterval)
			}, c.prototype._onDrag = function (a) {
				return ContentSelect.Range.unselectAll(), this._domElement.style.left = "" + (a.clientX - this._draggingOffset.x) + "px", this._domElement.style.top = "" + (a.clientY - this._draggingOffset.y) + "px"
			}, c.prototype._onStartDragging = function (a) {
				var b;
				return a.preventDefault(), this.isDragging() ? void 0 : (this._dragging = !0, this.addCSSClass("ct-toolbox--dragging"), b = this._domElement.getBoundingClientRect(), this._draggingOffset = {
					x: a.clientX - b.left,
					y: a.clientY - b.top
				}, document.addEventListener("mousemove", this._onDrag), document.addEventListener("mouseup", this._onStopDragging), ContentEdit.addCSSClass(document.body, "ce--dragging"))
			}, c.prototype._onStopDragging = function () {
				return this.isDragging() ? (this._contain(), document.removeEventListener("mousemove", this._onDrag), document.removeEventListener("mouseup", this._onStopDragging), this._draggingOffset = null, this._dragging = !1, this.removeCSSClass("ct-toolbox--dragging"), ContentEdit.removeCSSClass(document.body, "ce--dragging")) : void 0
			}, c
		}(b.WidgetUI), b.ToolUI = function (a) {
			function b(a) {
				this._onMouseUp = i(this._onMouseUp, this), this._onMouseLeave = i(this._onMouseLeave, this), this._onMouseDown = i(this._onMouseDown, this), this._addDOMEventListeners = i(this._addDOMEventListeners, this), b.__super__.constructor.call(this), this.tool = a, this._mouseDown = !1, this._disabled = !1
			}
			return h(b, a), b.prototype.apply = function (a, b) {
				var c, d;
				if (this.tool.canApply(a, b)) return d = {
					element: a,
					selection: b
				}, c = function (a) {
					return function (b) {
						return b ? a.dispatchEvent(a.createEvent("applied", d)) : void 0
					}
				}(this), this.dispatchEvent(this.createEvent("apply", d)) ? this.tool.apply(a, b, c) : void 0
			}, b.prototype.disabled = function (a) {
				if (void 0 === a) return this._disabled;
				if (this._disabled !== a) return this._disabled = a, a ? (this._mouseDown = !1, this.addCSSClass("ct-tool--disabled"), this.removeCSSClass("ct-tool--applied")) : this.removeCSSClass("ct-tool--disabled")
			}, b.prototype.mount = function (a, c) {
				return null == c && (c = null), this._domElement = this.constructor.createDiv(["ct-tool", "ct-tool--" + this.tool.icon]), this._domElement.setAttribute("data-ct-tooltip", ContentEdit._(this.tool.label)), b.__super__.mount.call(this, a, c)
			}, b.prototype.update = function (a, b) {
				return (!this.tool.requiresElement || a && a.isMounted()) && this.tool.canApply(a, b) ? (this.disabled(!1), this.tool.isApplied(a, b) ? this.addCSSClass("ct-tool--applied") : this.removeCSSClass("ct-tool--applied")) : void this.disabled(!0)
			}, b.prototype._addDOMEventListeners = function () {
				return this._domElement.addEventListener("mousedown", this._onMouseDown), this._domElement.addEventListener("mouseleave", this._onMouseLeave), this._domElement.addEventListener("mouseup", this._onMouseUp)
			}, b.prototype._onMouseDown = function (a) {
				return a.preventDefault(), this.disabled() ? void 0 : (this._mouseDown = !0, this.addCSSClass("ct-tool--down"))
			}, b.prototype._onMouseLeave = function () {
				return this._mouseDown = !1, this.removeCSSClass("ct-tool--down")
			}, b.prototype._onMouseUp = function () {
				var a, b;
				if (this._mouseDown) {
					if (a = ContentEdit.Root.get().focused(), this.tool.requiresElement && (!a || !a.isMounted())) return;
					b = null, a && a.selection && (b = a.selection()), this.apply(a, b)
				}
				return this._mouseDown = !1, this.removeCSSClass("ct-tool--down")
			}, b
		}(b.AnchoredComponentUI), b.AnchoredDialogUI = function (a) {
			function b() {
				b.__super__.constructor.call(this), this._position = [0, 0]
			}
			return h(b, a), b.prototype.mount = function () {
				return this._domElement = this.constructor.createDiv(["ct-widget", "ct-anchored-dialog"]), this.parent().domElement().appendChild(this._domElement), this._domElement.style.top = "" + this._position[1] + "px", this._domElement.style.left = "" + this._position[0] + "px"
			}, b.prototype.position = function (a) {
				return void 0 === a ? this._position.slice() : (this._position = a.slice(), this.isMounted() ? (this._domElement.style.top = "" + this._position[1] + "px", this._domElement.style.left = "" + this._position[0] + "px") : void 0)
			}, b
		}(b.WidgetUI), b.DialogUI = function (a) {
			function b(a) {
				null == a && (a = ""), b.__super__.constructor.call(this), this._busy = !1, this._caption = a
			}
			return h(b, a), b.prototype.busy = function (a) {
				if (void 0 === a) return this._busy;
				if (this._busy !== a && (this._busy = a, this.isMounted())) return this._busy ? ContentEdit.addCSSClass(this._domElement, "ct-dialog--busy") : ContentEdit.removeCSSClass(this._domElement, "ct-dialog--busy")
			}, b.prototype.caption = function (a) {
				return void 0 === a ? this._caption : (this._caption = a, this._domCaption.textContent = ContentEdit._(a))
			}, b.prototype.mount = function () {
				var a, b, c;
				return document.activeElement && (document.activeElement.blur(), window.getSelection().removeAllRanges()), a = ["ct-widget", "ct-dialog"], this._busy && a.push("ct-dialog--busy"), this._domElement = this.constructor.createDiv(a), this.parent().domElement().appendChild(this._domElement), c = this.constructor.createDiv(["ct-dialog__header"]), this._domElement.appendChild(c), this._domCaption = this.constructor.createDiv(["ct-dialog__caption"]), c.appendChild(this._domCaption), this.caption(this._caption), this._domClose = this.constructor.createDiv(["ct-dialog__close"]), c.appendChild(this._domClose), b = this.constructor.createDiv(["ct-dialog__body"]), this._domElement.appendChild(b), this._domView = this.constructor.createDiv(["ct-dialog__view"]), b.appendChild(this._domView), this._domControls = this.constructor.createDiv(["ct-dialog__controls"]), b.appendChild(this._domControls), this._domBusy = this.constructor.createDiv(["ct-dialog__busy"]), this._domElement.appendChild(this._domBusy)
			}, b.prototype.unmount = function () {
				return b.__super__.unmount.call(this), this._domBusy = null, this._domCaption = null, this._domClose = null, this._domControls = null, this._domView = null
			}, b.prototype._addDOMEventListeners = function () {
				return this._handleEscape = function (a) {
					return function (b) {
						return a._busy ? void 0 : 27 === b.keyCode ? a.dispatchEvent(a.createEvent("cancel")) : void 0
					}
				}(this), document.addEventListener("keyup", this._handleEscape), this._domClose.addEventListener("click", function (a) {
					return function (b) {
						return b.preventDefault(), a._busy ? void 0 : a.dispatchEvent(a.createEvent("cancel"))
					}
				}(this))
			}, b.prototype._removeDOMEventListeners = function () {
				return document.removeEventListener("keyup", this._handleEscape)
			}, b
		}(b.WidgetUI), b.ImageDialog = function (a) {
			function d() {
				d.__super__.constructor.call(this, "Insert image"), this._cropMarks = null, this._imageURL = null, this._imageSize = null, this._progress = 0, this._state = "empty", b.IMAGE_UPLOADER && b.IMAGE_UPLOADER(this)
			}
			return h(d, a), d.prototype.cropRegion = function () {
				return this._cropMarks ? this._cropMarks.region() : [0, 0, 1, 1]
			}, d.prototype.addCropMarks = function () {
				return this._cropMarks ? void 0 : (this._cropMarks = new c(this._imageSize), this._cropMarks.mount(this._domView), ContentEdit.addCSSClass(this._domCrop, "ct-control--active"))
			}, d.prototype.clear = function () {
				return this._domImage && (this._domImage.parentNode.removeChild(this._domImage), this._domImage = null), this._imageURL = null, this._imageSize = null, this.state("empty")
			}, d.prototype.mount = function () {
				var a, b, c;
				return d.__super__.mount.call(this), ContentEdit.addCSSClass(this._domElement, "ct-image-dialog"), ContentEdit.addCSSClass(this._domElement, "ct-image-dialog--empty"), ContentEdit.addCSSClass(this._domView, "ct-image-dialog__view"), c = this.constructor.createDiv(["ct-control-group", "ct-control-group--left"]), this._domControls.appendChild(c), this._domRotateCCW = this.constructor.createDiv(["ct-control", "ct-control--icon", "ct-control--rotate-ccw"]), this._domRotateCCW.setAttribute("data-ct-tooltip", ContentEdit._("Rotate") + " -90°"), c.appendChild(this._domRotateCCW), this._domRotateCW = this.constructor.createDiv(["ct-control", "ct-control--icon", "ct-control--rotate-cw"]), this._domRotateCW.setAttribute("data-ct-tooltip", ContentEdit._("Rotate") + " 90°"), c.appendChild(this._domRotateCW), this._domCrop = this.constructor.createDiv(["ct-control", "ct-control--icon", "ct-control--crop"]), this._domCrop.setAttribute("data-ct-tooltip", ContentEdit._("Crop marks")), c.appendChild(this._domCrop), b = this.constructor.createDiv(["ct-progress-bar"]), c.appendChild(b), this._domProgress = this.constructor.createDiv(["ct-progress-bar__progress"]), b.appendChild(this._domProgress), a = this.constructor.createDiv(["ct-control-group", "ct-control-group--right"]), this._domControls.appendChild(a), this._domUpload = this.constructor.createDiv(["ct-control", "ct-control--text", "ct-control--upload"]), this._domUpload.textContent = ContentEdit._("Upload"), a.appendChild(this._domUpload), this._domInput = document.createElement("input"), this._domInput.setAttribute("class", "ct-image-dialog__file-upload"), this._domInput.setAttribute("name", "file"), this._domInput.setAttribute("type", "file"), this._domInput.setAttribute("accept", "image/*"), this._domUpload.appendChild(this._domInput), this._domInsert = this.constructor.createDiv(["ct-control", "ct-control--text", "ct-control--insert"]), this._domInsert.textContent = ContentEdit._("Insert"), a.appendChild(this._domInsert), this._domCancelUpload = this.constructor.createDiv(["ct-control", "ct-control--text", "ct-control--cancel"]), this._domCancelUpload.textContent = ContentEdit._("Cancel"), a.appendChild(this._domCancelUpload), this._domClear = this.constructor.createDiv(["ct-control", "ct-control--text", "ct-control--clear"]), this._domClear.textContent = ContentEdit._("Clear"), a.appendChild(this._domClear), this._addDOMEventListeners(), this.dispatchEvent(this.createEvent("imageuploader.mount"))
			}, d.prototype.populate = function (a, b) {
				return this._imageURL = a, this._imageSize = b, this._domImage || (this._domImage = this.constructor.createDiv(["ct-image-dialog__image"]), this._domView.appendChild(this._domImage)), this._domImage.style["background-image"] = "url(" + a + ")", this.state("populated")
			}, d.prototype.progress = function (a) {
				return void 0 === a ? this._progress : (this._progress = a, this.isMounted() ? this._domProgress.style.width = "" + this._progress + "%" : void 0)
			}, d.prototype.removeCropMarks = function () {
				return this._cropMarks ? (this._cropMarks.unmount(), this._cropMarks = null, ContentEdit.removeCSSClass(this._domCrop, "ct-control--active")) : void 0
			}, d.prototype.save = function (a, b, c) {
				return this.dispatchEvent(this.createEvent("save", {
					imageURL: a,
					imageSize: b,
					imageAttrs: c
				}))
			}, d.prototype.state = function (a) {
				var b;
				if (void 0 === a) return this._state;
				if (this._state !== a && (b = this._state, this._state = a, this.isMounted())) return ContentEdit.addCSSClass(this._domElement, "ct-image-dialog--" + this._state), ContentEdit.removeCSSClass(this._domElement, "ct-image-dialog--" + b)
			}, d.prototype.unmount = function () {
				return d.__super__.unmount.call(this), this._domCancelUpload = null, this._domClear = null, this._domCrop = null, this._domInput = null, this._domInsert = null, this._domProgress = null, this._domRotateCCW = null, this._domRotateCW = null, this._domUpload = null, this.dispatchEvent(this.createEvent("imageuploader.unmount"))
			}, d.prototype._addDOMEventListeners = function () {
				return d.__super__._addDOMEventListeners.call(this), this._domInput.addEventListener("change", function (a) {
					return function (b) {
						var c;
						return c = b.target.files[0], b.target.value = "", b.target.value && (b.target.type = "text", b.target.type = "file"), a.dispatchEvent(a.createEvent("imageuploader.fileready", {
							file: c
						}))
					}
				}(this)), this._domCancelUpload.addEventListener("click", function (a) {
					return function () {
						return a.dispatchEvent(a.createEvent("imageuploader.cancelupload"))
					}
				}(this)), this._domClear.addEventListener("click", function (a) {
					return function () {
						return a.removeCropMarks(), a.dispatchEvent(a.createEvent("imageuploader.clear"))
					}
				}(this)), this._domRotateCCW.addEventListener("click", function (a) {
					return function () {
						return a.removeCropMarks(), a.dispatchEvent(a.createEvent("imageuploader.rotateccw"))
					}
				}(this)), this._domRotateCW.addEventListener("click", function (a) {
					return function () {
						return a.removeCropMarks(), a.dispatchEvent(a.createEvent("imageuploader.rotatecw"))
					}
				}(this)), this._domCrop.addEventListener("click", function (a) {
					return function () {
						return a._cropMarks ? a.removeCropMarks() : a.addCropMarks()
					}
				}(this)), this._domInsert.addEventListener("click", function (a) {
					return function () {
						return a.dispatchEvent(a.createEvent("imageuploader.save"))
					}
				}(this))
			}, d
		}(b.DialogUI), c = function (a) {
			function c(a) {
				c.__super__.constructor.call(this), this._bounds = null, this._dragging = null, this._draggingOrigin = null, this._imageSize = a
			}
			return h(c, a), c.prototype.mount = function (a, b) {
				return null == b && (b = null), this._domElement = this.constructor.createDiv(["ct-crop-marks"]), this._domClipper = this.constructor.createDiv(["ct-crop-marks__clipper"]), this._domElement.appendChild(this._domClipper), this._domRulers = [this.constructor.createDiv(["ct-crop-marks__ruler", "ct-crop-marks__ruler--top-left"]), this.constructor.createDiv(["ct-crop-marks__ruler", "ct-crop-marks__ruler--bottom-right"])], this._domClipper.appendChild(this._domRulers[0]), this._domClipper.appendChild(this._domRulers[1]), this._domHandles = [this.constructor.createDiv(["ct-crop-marks__handle", "ct-crop-marks__handle--top-left"]), this.constructor.createDiv(["ct-crop-marks__handle", "ct-crop-marks__handle--bottom-right"])], this._domElement.appendChild(this._domHandles[0]), this._domElement.appendChild(this._domHandles[1]), c.__super__.mount.call(this, a, b), this._fit(a)
			}, c.prototype.region = function () {
				return [parseFloat(this._domHandles[0].style.top) / this._bounds[1], parseFloat(this._domHandles[0].style.left) / this._bounds[0], parseFloat(this._domHandles[1].style.top) / this._bounds[1], parseFloat(this._domHandles[1].style.left) / this._bounds[0]]
			}, c.prototype.unmount = function () {
				return c.__super__.unmount.call(this), this._domClipper = null, this._domHandles = null, this._domRulers = null
			}, c.prototype._addDOMEventListeners = function () {
				return c.__super__._addDOMEventListeners.call(this), this._domHandles[0].addEventListener("mousedown", function (a) {
					return function (b) {
						return 0 === b.button ? a._startDrag(0, b.clientY, b.clientX) : void 0
					}
				}(this)), this._domHandles[1].addEventListener("mousedown", function (a) {
					return function (b) {
						return 0 === b.button ? a._startDrag(1, b.clientY, b.clientX) : void 0
					}
				}(this))
			}, c.prototype._drag = function (a, c) {
				var d, e, f, g, h;
				if (null !== this._dragging) return ContentSelect.Range.unselectAll(), g = a - this._draggingOrigin[1], f = c - this._draggingOrigin[0], d = this._bounds[1], c = 0, a = 0, h = this._bounds[0], e = Math.min(Math.min(b.MIN_CROP, d), h), 0 === this._dragging ? (d = parseInt(this._domHandles[1].style.top) - e, h = parseInt(this._domHandles[1].style.left) - e) : (c = parseInt(this._domHandles[0].style.left) + e, a = parseInt(this._domHandles[0].style.top) + e), g = Math.min(Math.max(a, g), d), f = Math.min(Math.max(c, f), h), this._domHandles[this._dragging].style.top = "" + g + "px", this._domHandles[this._dragging].style.left = "" + f + "px", this._domRulers[this._dragging].style.top = "" + g + "px", this._domRulers[this._dragging].style.left = "" + f + "px"
			}, c.prototype._fit = function (a) {
				var b, c, d, e, f, g, h, i;
				return f = a.getBoundingClientRect(), i = f.width / this._imageSize[0], c = f.height / this._imageSize[1], e = Math.min(i, c), h = e * this._imageSize[0], b = e * this._imageSize[1], d = (f.width - h) / 2, g = (f.height - b) / 2, this._domElement.style.width = "" + h + "px", this._domElement.style.height = "" + b + "px", this._domElement.style.top = "" + g + "px", this._domElement.style.left = "" + d + "px", this._domHandles[0].style.top = "0px", this._domHandles[0].style.left = "0px", this._domHandles[1].style.top = "" + b + "px", this._domHandles[1].style.left = "" + h + "px", this._domRulers[0].style.top = "0px", this._domRulers[0].style.left = "0px", this._domRulers[1].style.top = "" + b + "px", this._domRulers[1].style.left = "" + h + "px", this._bounds = [h, b]
			}, c.prototype._startDrag = function (a, b, c) {
				var d;
				return d = this._domHandles[a], this._dragging = a, this._draggingOrigin = [c - parseInt(d.style.left), b - parseInt(d.style.top)], this._onMouseMove = function (a) {
					return function (b) {
						return a._drag(b.clientY, b.clientX)
					}
				}(this), document.addEventListener("mousemove", this._onMouseMove), this._onMouseUp = function (a) {
					return function () {
						return a._stopDrag()
					}
				}(this), document.addEventListener("mouseup", this._onMouseUp)
			}, c.prototype._stopDrag = function () {
				return document.removeEventListener("mousemove", this._onMouseMove), document.removeEventListener("mouseup", this._onMouseUp), this._dragging = null, this._draggingOrigin = null
			}, c
		}(b.AnchoredComponentUI), b.LinkDialog = function (a) {
			function b(a, c) {
				null == a && (a = ""), null == c && (c = ""), b.__super__.constructor.call(this), this._href = a, this._target = c
			}
			var c;
			return h(b, a), c = "_blank", b.prototype.mount = function () {
				return b.__super__.mount.call(this), this._domInput = document.createElement("input"), this._domInput.setAttribute("class", "ct-anchored-dialog__input"), this._domInput.setAttribute("name", "href"), this._domInput.setAttribute("placeholder", ContentEdit._("Enter a link") + "..."), this._domInput.setAttribute("type", "text"), this._domInput.setAttribute("value", this._href), this._domElement.appendChild(this._domInput), this._domTargetButton = this.constructor.createDiv(["ct-anchored-dialog__target-button"]), this._domElement.appendChild(this._domTargetButton), this._target === c && ContentEdit.addCSSClass(this._domTargetButton, "ct-anchored-dialog__target-button--active"), this._domButton = this.constructor.createDiv(["ct-anchored-dialog__button"]), this._domElement.appendChild(this._domButton), this._addDOMEventListeners()
			}, b.prototype.save = function () {
				var a;
				return this.isMounted() ? (a = {
					href: this._domInput.value.trim()
				}, this._target && (a.target = this._target), this.dispatchEvent(this.createEvent("save", a))) : void this.dispatchEvent(this.createEvent("save"))
			}, b.prototype.show = function () {
				return b.__super__.show.call(this), this._domInput.focus(), this._href ? this._domInput.select() : void 0
			}, b.prototype.unmount = function () {
				return this.isMounted() && this._domInput.blur(), b.__super__.unmount.call(this), this._domButton = null, this._domInput = null
			}, b.prototype._addDOMEventListeners = function () {
				return this._domInput.addEventListener("keypress", function (a) {
					return function (b) {
						return 13 === b.keyCode ? a.save() : void 0
					}
				}(this)), this._domTargetButton.addEventListener("click", function (a) {
					return function (b) {
						return b.preventDefault(), a._target === c ? (a._target = "", ContentEdit.removeCSSClass(a._domTargetButton, "ct-anchored-dialog__target-button--active")) : (a._target = c, ContentEdit.addCSSClass(a._domTargetButton, "ct-anchored-dialog__target-button--active"))
					}
				}(this)), this._domButton.addEventListener("click", function (a) {
					return function (b) {
						return b.preventDefault(), a.save()
					}
				}(this))
			}, b
		}(b.AnchoredDialogUI), b.PropertiesDialog = function (c) {
			function e(a) {
				var b;
				this.element = a, e.__super__.constructor.call(this, "Properties"), this._attributeUIs = [], this._focusedAttributeUI = null, this._styleUIs = [], this._supportsCoding = this.element.content, ("ListItem" === (b = this.element.type()) || "TableCell" === b) && (this._supportsCoding = !0)
			}
			return h(e, c), e.prototype.caption = function (a) {
				return void 0 === a ? this._caption : (this._caption = a, this._domCaption.textContent = ContentEdit._(a) + (": " + this.element.tagName()))
			}, e.prototype.changedAttributes = function () {
				var a, c, d, e, f, g, h, i, j, k;
				for (c = {}, d = {}, j = this._attributeUIs, h = 0, i = j.length; i > h; h++) a = j[h], e = a.name(), g = a.value(), "" !== e && (c[e.toLowerCase()] = !0, this.element.attr(e) !== g && (d[e] = g));
				f = b.getRestrictedAtributes(this.element.tagName()), k = this.element.attributes();
				for (e in k) g = k[e], f && -1 !== f.indexOf(e.toLowerCase()) || void 0 === c[e] && (d[e] = null);
				return d
			}, e.prototype.changedStyles = function () {
				var a, b, c, d, e, f;
				for (c = {}, f = this._styleUIs, d = 0, e = f.length; e > d; d++) b = f[d], a = b.style.cssClass(), this.element.hasCSSClass(a) !== b.applied() && (c[a] = b.applied());
				return c
			}, e.prototype.getElementInnerHTML = function () {
				return this._supportsCoding ? this.element.content ? this.element.content.html() : this.element.children[0].content.html() : null
			}, e.prototype.mount = function () {
				var a, c, f, g, h, i, j, k, l, m, n, o, p, q, r;
				for (e.__super__.mount.call(this), ContentEdit.addCSSClass(this._domElement, "ct-properties-dialog"), ContentEdit.addCSSClass(this._domView, "ct-properties-dialog__view"), this._domStyles = this.constructor.createDiv(["ct-properties-dialog__styles"]), this._domStyles.setAttribute("data-ct-empty", ContentEdit._("No styles available for this tag")), this._domView.appendChild(this._domStyles), /*r = b.StylePalette.styles(this.element),*/ n = 0, p = r.length; p > n; n++) k = r[n], l = new d(k, this.element.hasCSSClass(k.cssClass())), this._styleUIs.push(l), l.mount(this._domStyles);
				this._domAttributes = this.constructor.createDiv(["ct-properties-dialog__attributes"]), this._domView.appendChild(this._domAttributes), j = b.getRestrictedAtributes(this.element.tagName()), c = this.element.attributes(), a = [];
				for (i in c) m = c[i], j && -1 !== j.indexOf(i.toLowerCase()) || a.push(i);
				for (a.sort(), o = 0, q = a.length; q > o; o++) i = a[o], m = c[i], this._addAttributeUI(i, m);
				return this._addAttributeUI("", ""), this._domCode = this.constructor.createDiv(["ct-properties-dialog__code"]), this._domView.appendChild(this._domCode), this._domInnerHTML = document.createElement("textarea"), this._domInnerHTML.setAttribute("class", "ct-properties-dialog__inner-html"), this._domInnerHTML.setAttribute("name", "code"), this._domInnerHTML.value = this.getElementInnerHTML(), this._domCode.appendChild(this._domInnerHTML), g = this.constructor.createDiv(["ct-control-group", "ct-control-group--left"]), this._domControls.appendChild(g), this._domStylesTab = this.constructor.createDiv(["ct-control", "ct-control--icon", "ct-control--styles"]), this._domStylesTab.setAttribute("data-ct-tooltip", ContentEdit._("Styles")), g.appendChild(this._domStylesTab), this._domAttributesTab = this.constructor.createDiv(["ct-control", "ct-control--icon", "ct-control--attributes"]), this._domAttributesTab.setAttribute("data-ct-tooltip", ContentEdit._("Attributes")), g.appendChild(this._domAttributesTab), this._domCodeTab = this.constructor.createDiv(["ct-control", "ct-control--icon", "ct-control--code"]), this._domCodeTab.setAttribute("data-ct-tooltip", ContentEdit._("Code")), g.appendChild(this._domCodeTab), this._supportsCoding || ContentEdit.addCSSClass(this._domCodeTab, "ct-control--muted"), this._domRemoveAttribute = this.constructor.createDiv(["ct-control", "ct-control--icon", "ct-control--remove", "ct-control--muted"]), this._domRemoveAttribute.setAttribute("data-ct-tooltip", ContentEdit._("Remove")), g.appendChild(this._domRemoveAttribute), f = this.constructor.createDiv(["ct-control-group", "ct-control-group--right"]), this._domControls.appendChild(f), this._domApply = this.constructor.createDiv(["ct-control", "ct-control--text", "ct-control--apply"]), this._domApply.textContent = ContentEdit._("Apply"), f.appendChild(this._domApply), h = window.localStorage.getItem("ct-properties-dialog-tab"), "attributes" === h ? (ContentEdit.addCSSClass(this._domElement, "ct-properties-dialog--attributes"), ContentEdit.addCSSClass(this._domAttributesTab, "ct-control--active")) : "code" === h && this._supportsCoding ? (ContentEdit.addCSSClass(this._domElement, "ct-properties-dialog--code"), ContentEdit.addCSSClass(this._domCodeTab, "ct-control--active")) : (ContentEdit.addCSSClass(this._domElement, "ct-properties-dialog--styles"), ContentEdit.addCSSClass(this._domStylesTab, "ct-control--active")), this._addDOMEventListeners()
			}, e.prototype.save = function () {
				var a, b;
				return b = null, this._supportsCoding && (b = this._domInnerHTML.value), a = {
					changedAttributes: this.changedAttributes(),
					changedStyles: this.changedStyles(),
					innerHTML: b
				}, this.dispatchEvent(this.createEvent("save", a))
			}, e.prototype._addAttributeUI = function (c, d) {
				var e, f;
				return f = this, e = new a(c, d), this._attributeUIs.push(e), e.addEventListener("blur", function () {
					var a, b, c;
					return f._focusedAttributeUI = null, ContentEdit.addCSSClass(f._domRemoveAttribute, "ct-control--muted"), a = f._attributeUIs.indexOf(this), c = f._attributeUIs.length, "" === this.name() && c - 1 > a && (this.unmount(), f._attributeUIs.splice(a, 1)), b = f._attributeUIs[c - 1], b && b.name() && b.value() ? f._addAttributeUI("", "") : void 0
				}), e.addEventListener("focus", function () {
					return f._focusedAttributeUI = this, ContentEdit.removeCSSClass(f._domRemoveAttribute, "ct-control--muted")
				}), e.addEventListener("namechange", function () {
					var a, d, e, g, h, i, j;
					for (a = f.element, c = this.name().toLowerCase(), e = b.getRestrictedAtributes(a.tagName()), g = !0, e && -1 !== e.indexOf(c) && (g = !1), j = f._attributeUIs, h = 0, i = j.length; i > h; h++) d = j[h], "" !== c && d !== this && d.name().toLowerCase() === c && (g = !1);
					return this.valid(g), g ? ContentEdit.removeCSSClass(f._domApply, "ct-control--muted") : ContentEdit.addCSSClass(f._domApply, "ct-control--muted")
				}), e.mount(this._domAttributes), e
			}, e.prototype._addDOMEventListeners = function () {
				var a, b;
				return e.__super__._addDOMEventListeners.call(this), a = function (a) {
					return function (b) {
						var c, d, e, f, g, h;
						for (f = ["attributes", "code", "styles"], g = 0, h = f.length; h > g; g++) d = f[g], d !== b && (e = d.charAt(0).toUpperCase() + d.slice(1), ContentEdit.removeCSSClass(a._domElement, "ct-properties-dialog--" + d), ContentEdit.removeCSSClass(a["_dom" + e + "Tab"], "ct-control--active"));
						return c = b.charAt(0).toUpperCase() + b.slice(1), ContentEdit.addCSSClass(a._domElement, "ct-properties-dialog--" + b), ContentEdit.addCSSClass(a["_dom" + c + "Tab"], "ct-control--active"), window.localStorage.setItem("ct-properties-dialog-tab", b)
					}
				}(this), this._domStylesTab.addEventListener("mousedown", function () {
					return function () {
						return a("styles")
					}
				}(this)), this._domAttributesTab.addEventListener("mousedown", function () {
					return function () {
						return a("attributes")
					}
				}(this)), this._supportsCoding && this._domCodeTab.addEventListener("mousedown", function () {
					return function () {
						return a("code")
					}
				}(this)), this._domRemoveAttribute.addEventListener("mousedown", function (a) {
					return function (b) {
						var c, d;
						return b.preventDefault(), a._focusedAttributeUI && (c = a._attributeUIs.indexOf(a._focusedAttributeUI), d = c === a._attributeUIs.length - 1, a._focusedAttributeUI.unmount(), a._attributeUIs.splice(c, 1), d) ? a._addAttributeUI("", "") : void 0
					}
				}(this)), b = function (a) {
					return function () {
						var b;
						try {
							return b = new HTMLString.String(a._domInnerHTML.value), ContentEdit.removeCSSClass(a._domInnerHTML, "ct-properties-dialog__inner-html--invalid"), ContentEdit.removeCSSClass(a._domApply, "ct-control--muted")
						} catch (c) {
							return ContentEdit.addCSSClass(a._domInnerHTML, "ct-properties-dialog__inner-html--invalid"), ContentEdit.addCSSClass(a._domApply, "ct-control--muted")
						}
					}
				}(this), this._domInnerHTML.addEventListener("input", b), this._domInnerHTML.addEventListener("propertychange", b), this._domApply.addEventListener("click", function (a) {
					return function (b) {
						var c;
						return b.preventDefault(), c = a._domApply.getAttribute("class"), -1 === c.indexOf("ct-control--muted") ? a.save() : void 0
					}
				}(this))
			}, e
		}(b.DialogUI), d = function (a) {
			function b(a, c) {
				this.style = a, b.__super__.constructor.call(this), this._applied = c
			}
			return h(b, a), b.prototype.applied = function (a) {
				if (void 0 === a) return this._applied;
				if (this._applied !== a) return this._applied = a, this._applied ? ContentEdit.addCSSClass(this._domElement, "ct-section--applied") : ContentEdit.removeCSSClass(this._domElement, "ct-section--applied")
			}, b.prototype.mount = function (a, c) {
				var d;
				return null == c && (c = null), this._domElement = this.constructor.createDiv(["ct-section"]), this._applied && ContentEdit.addCSSClass(this._domElement, "ct-section--applied"), d = this.constructor.createDiv(["ct-section__label"]), d.textContent = this.style.name(), this._domElement.appendChild(d), this._domElement.appendChild(this.constructor.createDiv(["ct-section__switch"])), b.__super__.mount.call(this, a, c)
			}, b.prototype._addDOMEventListeners = function () {
				var a;
				return a = function (a) {
					return function (b) {
						return b.preventDefault(), a.applied(a.applied() ? !1 : !0)
					}
				}(this), this._domElement.addEventListener("click", a)
			}, b
		}(b.AnchoredComponentUI), a = function (a) {
			function b(a, c) {
				b.__super__.constructor.call(this), this._initialName = a, this._initialValue = c
			}
			return h(b, a), b.prototype.name = function () {
				return this._domName.value.trim()
			}, b.prototype.value = function () {
				return this._domValue.value.trim()
			}, b.prototype.mount = function (a, c) {
				return null == c && (c = null), this._domElement = this.constructor.createDiv(["ct-attribute"]), this._domName = document.createElement("input"), this._domName.setAttribute("class", "ct-attribute__name"), this._domName.setAttribute("name", "name"), this._domName.setAttribute("placeholder", ContentEdit._("Name")), this._domName.setAttribute("type", "text"), this._domName.setAttribute("value", this._initialName), this._domElement.appendChild(this._domName), this._domValue = document.createElement("input"), this._domValue.setAttribute("class", "ct-attribute__value"), this._domValue.setAttribute("name", "value"), this._domValue.setAttribute("placeholder", ContentEdit._("Value")), this._domValue.setAttribute("type", "text"), this._domValue.setAttribute("value", this._initialValue), this._domElement.appendChild(this._domValue), b.__super__.mount.call(this, a, c)
			}, b.prototype.valid = function (a) {
				return a ? ContentEdit.removeCSSClass(this._domName, "ct-attribute__name--invalid") : ContentEdit.addCSSClass(this._domName, "ct-attribute__name--invalid")
			}, b.prototype._addDOMEventListeners = function () {
				return this._domName.addEventListener("blur", function (a) {
					return function () {
						var b, c, d;
						return b = a.name(), c = a._domElement.nextSibling, a.dispatchEvent(a.createEvent("blur")), "" === b && c ? (d = c.querySelector(".ct-attribute__name"), d.focus()) : void 0
					}
				}(this)), this._domName.addEventListener("focus", function (a) {
					return function () {
						return a.dispatchEvent(a.createEvent("focus"))
					}
				}(this)), this._domName.addEventListener("input", function (a) {
					return function () {
						return a.dispatchEvent(a.createEvent("namechange"))
					}
				}(this)), this._domName.addEventListener("keydown", function (a) {
					return function (b) {
						return 13 === b.keyCode ? a._domValue.focus() : void 0
					}
				}(this)), this._domValue.addEventListener("blur", function (a) {
					return function () {
						return a.dispatchEvent(a.createEvent("blur"))
					}
				}(this)), this._domValue.addEventListener("focus", function (a) {
					return function () {
						return a.dispatchEvent(a.createEvent("focus"))
					}
				}(this)), this._domValue.addEventListener("keydown", function (a) {
					return function (b) {
						var c, d;
						if (13 === b.keyCode || 9 === b.keyCode && !b.shiftKey) return b.preventDefault(), c = a._domElement.nextSibling, c || (a._domValue.blur(), c = a._domElement.nextSibling), c ? (d = c.querySelector(".ct-attribute__name"), d.focus()) : void 0
					}
				}(this))
			}, b
		}(b.AnchoredComponentUI), b.TableDialog = function (a) {
			function b(a) {
				this.table = a, this.table ? b.__super__.constructor.call(this, "Update table") : b.__super__.constructor.call(this, "Insert table")
			}
			return h(b, a), b.prototype.mount = function () {
				var a, c, d, e, f, g, h;
				return b.__super__.mount.call(this), a = {
					columns: 3,
					foot: !1,
					head: !0
				}, this.table && (a = {
					columns: this.table.firstSection().children[0].children.length,
					foot: this.table.tfoot(),
					head: this.table.thead()
				}), ContentEdit.addCSSClass(this._domElement, "ct-table-dialog"), ContentEdit.addCSSClass(this._domView, "ct-table-dialog__view"), h = ["ct-section"], a.head && h.push("ct-section--applied"), this._domHeadSection = this.constructor.createDiv(h), this._domView.appendChild(this._domHeadSection), f = this.constructor.createDiv(["ct-section__label"]), f.textContent = ContentEdit._("Table head"), this._domHeadSection.appendChild(f), this._domHeadSwitch = this.constructor.createDiv(["ct-section__switch"]), this._domHeadSection.appendChild(this._domHeadSwitch), this._domBodySection = this.constructor.createDiv(["ct-section", "ct-section--applied", "ct-section--contains-input"]), this._domView.appendChild(this._domBodySection), c = this.constructor.createDiv(["ct-section__label"]), c.textContent = ContentEdit._("Table body (columns)"), this._domBodySection.appendChild(c), this._domBodyInput = document.createElement("input"), this._domBodyInput.setAttribute("class", "ct-section__input"), this._domBodyInput.setAttribute("maxlength", "2"), this._domBodyInput.setAttribute("name", "columns"), this._domBodyInput.setAttribute("type", "text"), this._domBodyInput.setAttribute("value", a.columns), this._domBodySection.appendChild(this._domBodyInput), g = ["ct-section"], a.foot && g.push("ct-section--applied"), this._domFootSection = this.constructor.createDiv(g), this._domView.appendChild(this._domFootSection), e = this.constructor.createDiv(["ct-section__label"]), e.textContent = ContentEdit._("Table foot"), this._domFootSection.appendChild(e), this._domFootSwitch = this.constructor.createDiv(["ct-section__switch"]), this._domFootSection.appendChild(this._domFootSwitch), d = this.constructor.createDiv(["ct-control-group", "ct-control-group--right"]), this._domControls.appendChild(d), this._domApply = this.constructor.createDiv(["ct-control", "ct-control--text", "ct-control--apply"]), this._domApply.textContent = "Apply", d.appendChild(this._domApply), this._addDOMEventListeners()
			}, b.prototype.save = function () {
				var a, b, c;
				return b = this._domFootSection.getAttribute("class"), c = this._domHeadSection.getAttribute("class"), a = {
					columns: parseInt(this._domBodyInput.value),
					foot: b.indexOf("ct-section--applied") > -1,
					head: c.indexOf("ct-section--applied") > -1
				}, this.dispatchEvent(this.createEvent("save", a))
			}, b.prototype.unmount = function () {
				return b.__super__.unmount.call(this), this._domBodyInput = null, this._domBodySection = null, this._domApply = null, this._domHeadSection = null, this._domHeadSwitch = null, this._domFootSection = null, this._domFootSwitch = null
			}, b.prototype._addDOMEventListeners = function () {
				var a;
				return b.__super__._addDOMEventListeners.call(this), a = function (a) {
					return a.preventDefault(), this.getAttribute("class").indexOf("ct-section--applied") > -1 ? ContentEdit.removeCSSClass(this, "ct-section--applied") : ContentEdit.addCSSClass(this, "ct-section--applied")
				}, this._domHeadSection.addEventListener("click", a), this._domFootSection.addEventListener("click", a), this._domBodySection.addEventListener("click", function (a) {
					return function () {
						return a._domBodyInput.focus()
					}
				}(this)), this._domBodyInput.addEventListener("input", function (a) {
					return function (b) {
						var c;
						return c = /^[1-9]\d{0,1}$/.test(b.target.value), c ? (ContentEdit.removeCSSClass(a._domBodyInput, "ct-section__input--invalid"), ContentEdit.removeCSSClass(a._domApply, "ct-control--muted")) : (ContentEdit.addCSSClass(a._domBodyInput, "ct-section__input--invalid"), ContentEdit.addCSSClass(a._domApply, "ct-control--muted"))
					}
				}(this)), this._domApply.addEventListener("click", function (a) {
					return function (b) {
						var c;
						return b.preventDefault(), c = a._domApply.getAttribute("class"), -1 === c.indexOf("ct-control--muted") ? a.save() : void 0
					}
				}(this))
			}, b
		}(b.DialogUI), b.VideoDialog = function (a) {
			function c() {
				c.__super__.constructor.call(this, "Insert video")
			}
			return h(c, a), c.prototype.clearPreview = function () {
				return this._domPreview ? (this._domPreview.parentNode.removeChild(this._domPreview), this._domPreview = void 0) : void 0
			}, c.prototype.mount = function () {
				var a;
				return c.__super__.mount.call(this), ContentEdit.addCSSClass(this._domElement, "ct-video-dialog"), ContentEdit.addCSSClass(this._domView, "ct-video-dialog__preview"), a = this.constructor.createDiv(["ct-control-group"]), this._domControls.appendChild(a), this._domInput = document.createElement("input"), this._domInput.setAttribute("class", "ct-video-dialog__input"), this._domInput.setAttribute("name", "url"), this._domInput.setAttribute("placeholder", ContentEdit._("Paste YouTube or Vimeo URL") + "..."), this._domInput.setAttribute("type", "text"), a.appendChild(this._domInput), this._domButton = this.constructor.createDiv(["ct-control", "ct-control--text", "ct-control--insert", "ct-control--muted"]), this._domButton.textContent = ContentEdit._("Insert"), a.appendChild(this._domButton), this._addDOMEventListeners()
			}, c.prototype.preview = function (a) {
				return this.clearPreview(), this._domPreview = document.createElement("iframe"), this._domPreview.setAttribute("frameborder", "0"), this._domPreview.setAttribute("height", "100%"), this._domPreview.setAttribute("src", a), this._domPreview.setAttribute("width", "100%"), this._domView.appendChild(this._domPreview)
			}, c.prototype.save = function () {
				var a, c;
				return c = this._domInput.value.trim(), a = b.getEmbedVideoURL(c), this.dispatchEvent(a ? this.createEvent("save", {
					url: a
				}) : this.createEvent("save", {
					url: c
				}))
			}, c.prototype.show = function () {
				return c.__super__.show.call(this), this._domInput.focus()
			}, c.prototype.unmount = function () {
				return this.isMounted() && this._domInput.blur(), c.__super__.unmount.call(this), this._domButton = null, this._domInput = null, this._domPreview = null
			}, c.prototype._addDOMEventListeners = function () {
				return c.__super__._addDOMEventListeners.call(this), this._domInput.addEventListener("input", function (a) {
					return function (c) {
						var d;
						return c.target.value ? ContentEdit.removeCSSClass(a._domButton, "ct-control--muted") : ContentEdit.addCSSClass(a._domButton, "ct-control--muted"), a._updatePreviewTimeout && clearTimeout(a._updatePreviewTimeout), d = function () {
							var c, d;
							return d = a._domInput.value.trim(), c = b.getEmbedVideoURL(d), c ? a.preview(c) : a.clearPreview()
						}, a._updatePreviewTimeout = setTimeout(d, 500)
					}
				}(this)), this._domInput.addEventListener("keypress", function (a) {
					return function (b) {
						return 13 === b.keyCode ? a.save() : void 0
					}
				}(this)), this._domButton.addEventListener("click", function (a) {
					return function (b) {
						var c;
						return b.preventDefault(), c = a._domButton.getAttribute("class"), -1 === c.indexOf("ct-control--muted") ? a.save() : void 0
					}
				}(this))
			}, c
		}(b.DialogUI), f = function (a) {
			function c() {
				c.__super__.constructor.call(this), this.history = null, this._state = "dormant", this._busy = !1, this._namingProp = null, this._fixtureTest = function (a) {
					return a.hasAttribute("data-fixture")
				}, this._regionQuery = null, this._domRegions = null, this._regions = {}, this._orderedRegions = [], this._rootLastModified = null, this._regionsLastModified = {}, this._ignition = null, this._inspector = null, this._toolbox = null, this._emptyRegionsAllowed = !1
			}
			return h(c, a), c.prototype.ctrlDown = function () {
				return this._ctrlDown
			}, c.prototype.domRegions = function () {
				return this._domRegions
			}, c.prototype.getState = function () {
				return this._state
			}, c.prototype.ignition = function () {
				return this._ignition
			}, c.prototype.inspector = function () {
				return this._inspector
			}, c.prototype.isDormant = function () {
				return "dormant" === this._state
			}, c.prototype.isReady = function () {
				return "ready" === this._state
			}, c.prototype.isEditing = function () {
				return "editing" === this._state
			}, c.prototype.orderedRegions = function () {
				var a;
				return function () {
					var b, c, d, e;
					for (d = this._orderedRegions, e = [], b = 0, c = d.length; c > b; b++) a = d[b], e.push(this._regions[a]);
					return e
				}.call(this)
			}, c.prototype.regions = function () {
				return this._regions
			}, c.prototype.shiftDown = function () {
				return this._shiftDown
			}, c.prototype.toolbox = function () {
				return this._toolbox
			}, c.prototype.busy = function (a) {
				return void 0 === a && (this._busy = a), this._busy = a, this._ignition ? this._ignition.busy(a) : void 0
			}, c.prototype.createPlaceholderElement = function () {
				return new ContentEdit.Text("p", {}, "")
			}, c.prototype.init = function (a, c, d, e) {
				return null == c && (c = "id"), null == d && (d = null), null == e && (e = !0), this._namingProp = c, d && (this._fixtureTest = d), this.mount(), e && (this._ignition = new b.IgnitionUI, this.attach(this._ignition), this._ignition.addEventListener("edit", function (a) {
					return function (b) {
						return b.preventDefault(), a.start(), a._ignition.state("editing")
					}
				}(this)), this._ignition.addEventListener("confirm", function (a) {
					return function (b) {
						return b.preventDefault(), a._ignition.state("ready"), a.stop(!0)
					}
				}(this)), this._ignition.addEventListener("cancel", function (a) {
					return function (b) {
						return b.preventDefault(), a.stop(!1), a._ignition.state(a.isEditing() ? "editing" : "ready")
					}
				}(this))), this._toolbox = new b.ToolboxUI(b.DEFAULT_TOOLS), this.attach(this._toolbox), this._inspector = new b.InspectorUI, this.attach(this._inspector), this._state = "ready", this._handleDetach = function (a) {
					return function () {
						return a._preventEmptyRegions()
					}
				}(this), this._handleClipboardPaste = function (a) {
					return function (b, c) {
						var d;
						return d = null, c.clipboardData && (d = c.clipboardData.getData("text/plain")), window.clipboardData && (d = window.clipboardData.getData("TEXT")), a.paste(b, d)
					}
				}(this), this._handleNextRegionTransition = function (a) {
					return function (b) {
						var c, d, e, f, g, h, i;
						if (f = a.orderedRegions(), e = f.indexOf(b), !(e >= f.length - 1)) {
							for (b = f[e + 1], d = null, i = b.descendants(), g = 0, h = i.length; h > g; g++)
								if (c = i[g], void 0 !== c.content) {
									d = c;
									break
								}
							return d ? (d.focus(), void d.selection(new ContentSelect.Range(0, 0))) : ContentEdit.Root.get().trigger("next-region", b)
						}
					}
				}(this), this._handlePreviousRegionTransition = function (a) {
					return function (b) {
						var c, d, e, f, g, h, i, j;
						if (h = a.orderedRegions(), f = h.indexOf(b), !(0 >= f)) {
							for (b = h[f - 1], e = null, d = b.descendants(), d.reverse(), i = 0, j = d.length; j > i; i++)
								if (c = d[i], void 0 !== c.content) {
									e = c;
									break
								}
							return e ? (g = e.content.length(), e.focus(), void e.selection(new ContentSelect.Range(g, g))) : ContentEdit.Root.get().trigger("previous-region", b)
						}
					}
				}(this), ContentEdit.Root.get().bind("detach", this._handleDetach), ContentEdit.Root.get().bind("paste", this._handleClipboardPaste), ContentEdit.Root.get().bind("next-region", this._handleNextRegionTransition), ContentEdit.Root.get().bind("previous-region", this._handlePreviousRegionTransition), this.syncRegions(a)
			}, c.prototype.destroy = function () {
				return ContentEdit.Root.get().unbind("detach", this._handleDetach), ContentEdit.Root.get().unbind("paste", this._handleClipboardPaste), ContentEdit.Root.get().unbind("next-region", this._handleNextRegionTransition), ContentEdit.Root.get().unbind("previous-region", this._handlePreviousRegionTransition), this.unmount()
			}, c.prototype.highlightRegions = function (a) {
				var b, c, d, e, f;
				for (e = this._domRegions, f = [], c = 0, d = e.length; d > c; c++) b = e[c], f.push(a ? ContentEdit.addCSSClass(b, "ct--highlight") : ContentEdit.removeCSSClass(b, "ct--highlight"));
				return f
			}, c.prototype.mount = function () {
				return this._domElement = this.constructor.createDiv(["ct-app"]), document.body.insertBefore(this._domElement, null), this._addDOMEventListeners()
			}, c.prototype.paste = function (a, b) {
				var c, d, e, f, g, h, i, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z;
				if (d = b, q = d.split("\n"), q = q.filter(function (a) {
						return "" !== a.trim()
					})) {
					if (f = HTMLString.String.encode, t = !0, x = a.type(), 1 === q.length && (t = !1), "PreText" === x && (t = !1), a.can("spawn") || (t = !1), t) {
						for ("ListItemText" === x ? (k = a.parent(), i = a.parent().parent(), h = i.children.indexOf(k) + 1) : (k = a, "Region" !== k.parent().type() && (k = a.closest(function (a) {
								return "Region" === a.parent().type()
							})), i = k.parent(), h = i.children.indexOf(k) + 1), g = y = 0, z = q.length; z > y; g = ++y) o = q[g], o = f(o), "ListItemText" === x ? (l = new ContentEdit.ListItem, m = new ContentEdit.ListItemText(o), l.attach(m), n = m) : (l = new ContentEdit.Text("p", {}, o), n = l), i.attach(l, h + g);
						return p = n.content.length(), n.focus(), n.selection(new ContentSelect.Range(p, p))
					}
					return d = f(d), d = new HTMLString.String(d, "PreText" === x), s = a.selection(), e = s.get()[0] + d.length(), w = a.content.substring(0, s.get()[0]), v = a.content.substring(s.get()[1]), r = a.content.substring(s.get()[0], s.get()[1]), r.length() && (c = r.characters[0], u = c.tags(), c.isTag() && u.shift(), u.length >= 1 && (d = d.format.apply(d, [0, d.length()].concat(j.call(u))))), a.content = w.concat(d), a.content = a.content.concat(v, !1), a.updateInnerHTML(), a.taint(), s.set(e, e), a.selection(s)
				}
			}, c.prototype.unmount = function () {
				return this.isMounted() ? (this._domElement.parentNode.removeChild(this._domElement), this._domElement = null, this._removeDOMEventListeners(), this._ignition = null, this._inspector = null, this._toolbox = null) : void 0
			}, c.prototype.revert = function () {
				var a;
				if (this.dispatchEvent(this.createEvent("revert"))) return a = ContentEdit._("Your changes have not been saved, do you really want to lose them?"), ContentEdit.Root.get().lastModified() > this._rootLastModified && !window.confirm(a) ? !1 : (this.revertToSnapshot(this.history.goTo(0), !1), !0)
			}, c.prototype.revertToSnapshot = function (a, b) {
				var c, d, e, f, g, h, i;
				null == b && (b = !0), h = this._regions;
				for (d in h) {
					for (e = h[d], i = e.children, f = 0, g = i.length; g > f; f++) c = i[f], c.unmount();
					e.domElement().innerHTML = a.regions[d]
				}
				return b ? (ContentEdit.Root.get().focused() && ContentEdit.Root.get().focused().blur(), this._regions = {}, this.syncRegions(), this.history.replaceRegions(this._regions), this.history.restoreSelection(a), this._inspector.updateTags()) : void 0
			}, c.prototype.save = function (a) {
				var b, c, d, e, f, g, h, i, j, k;
				if (this.dispatchEvent(this.createEvent("save", {
						passive: a
					}))) {
					if (g = ContentEdit.Root.get(), g.lastModified() === this._rootLastModified && a) return void this.dispatchEvent(this.createEvent("saved", {
						regions: {},
						passive: a
					}));
					d = {}, j = this._regions;
					for (e in j) {
						if (f = j[e], c = f.html(), 1 === f.children.length && (b = f.children[0], b.content && !b.content.html() && (c = "")), !a) {
							for (k = f.children, h = 0, i = k.length; i > h; h++) b = k[h], b.unmount();
							f.domElement().innerHTML = c
						}
						f.lastModified() !== this._regionsLastModified[e] && (d[e] = c, this._regionsLastModified[e] = f.lastModified())
					}
					return this.dispatchEvent(this.createEvent("saved", {
						regions: d,
						passive: a
					}))
				}
			}, c.prototype.setRegionOrder = function (a) {
				return this._orderedRegions = a.slice()
			}, c.prototype.start = function () {
				return this.dispatchEvent(this.createEvent("start")) ? (this.busy(!0), this.syncRegions(), this._initRegions(), this._preventEmptyRegions(), this._rootLastModified = ContentEdit.Root.get().lastModified(), this.history = new b.History(this._regions), this.history.watch(), this._state = "editing", this._toolbox.show(), this._inspector.show(), this.busy(!1)) : void 0
			}, c.prototype.stop = function (a) {
				var b;
				if (this.dispatchEvent(this.createEvent("stop", {
						save: a
					}))) {
					if (b = ContentEdit.Root.get().focused(), b && b.isMounted() && void 0 !== b._syncContent && b._syncContent(), a) this.save();
					else if (!this.revert()) return;
					this.history.stopWatching(), this.history = null, this._toolbox.hide(), this._inspector.hide(), this._regions = {}, this._state = "ready", ContentEdit.Root.get().focused() && this._allowEmptyRegions(function () {
						return function () {
							return ContentEdit.Root.get().focused().blur()
						}
					}(this))
				}
			}, c.prototype.syncRegions = function (a) {
				return void 0 !== a && (this._regionQuery = a), this._domRegions = this._regionQuery.length > 0 && this._regionQuery[0].nodeType === Node.ELEMENT_NODE ? this._regionQuery : document.querySelectorAll(this._regionQuery), "editing" === this._state && this._initRegions(), this._ignition ? this._domRegions.length ? this._ignition.show() : this._ignition.hide() : void 0
			}, c.prototype._addDOMEventListeners = function () {
				return this._handleHighlightOn = function (a) {
					return function (c) {
						var d;
						if (17 === (d = c.keyCode) || 224 === d || 91 === d || 93 === d) return void(a._ctrlDown = !0);
						if (16 === c.keyCode) {
							if (a._highlightTimeout) return;
							return a._shiftDown = !0, void(a._highlightTimeout = setTimeout(function () {
								return a.highlightRegions(!0)
							}, b.HIGHLIGHT_HOLD_DURATION))
						}
						return clearTimeout(a._highlightTimeout), a.highlightRegions(!1)
					}
				}(this), this._handleHighlightOff = function (a) {
					return function (b) {
						var c;
						return 17 === (c = b.keyCode) || 224 === c ? void(a._ctrlDown = !1) : 16 === b.keyCode ? (a._shiftDown = !1, a._highlightTimeout && (clearTimeout(a._highlightTimeout), a._highlightTimeout = null), a.highlightRegions(!1)) : void 0
					}
				}(this), this._handleVisibility = function (a) {
					return function () {
						return document.hasFocus() ? void 0 : (clearTimeout(a._highlightTimeout), a.highlightRegions(!1))
					}
				}(this), document.addEventListener("keydown", this._handleHighlightOn), document.addEventListener("keyup", this._handleHighlightOff), document.addEventListener("visibilitychange", this._handleVisibility), this._handleBeforeUnload = function (a) {
					return function (c) {
						var d;
						return "editing" === a._state ? (d = ContentEdit._(b.CANCEL_MESSAGE), (c || window.event).returnValue = d, d) : void 0
					}
				}(this), window.addEventListener("beforeunload", this._handleBeforeUnload), this._handleUnload = function (a) {
					return function () {
						return a.destroy()
					}
				}(this), window.addEventListener("unload", this._handleUnload)
			}, c.prototype._allowEmptyRegions = function (a) {
				return this._emptyRegionsAllowed = !0, a(), this._emptyRegionsAllowed = !1
			}, c.prototype._preventEmptyRegions = function () {
				var a, b, c, d, e, f, g, h, i, j, k;
				if (!this._emptyRegionsAllowed) {
					i = this._regions, k = [];
					for (d in i) {
						for (f = i[d], c = f.lastModified(), b = !1, j = f.children, g = 0, h = j.length; h > g; g++)
							if (a = j[g], "Static" !== a.type()) {
								b = !0;
								break
							}
						b || (e = this.createPlaceholderElement(f), f.attach(e), k.push(f._modified = c))
					}
					return k
				}
			}, c.prototype._removeDOMEventListeners = function () {
				return document.removeEventListener("keydown", this._handleHighlightOn), document.removeEventListener("keyup", this._handleHighlightOff), window.removeEventListener("beforeunload", this._handleBeforeUnload), window.removeEventListener("unload", this._handleUnload)
			}, c.prototype._initRegions = function () {
				var a, b, c, d, e, f, g, h, i, j, k;
				for (b = {}, this._orderedRegions = [], i = this._domRegions, c = g = 0, h = i.length; h > g; c = ++g) a = i[c], e = a.getAttribute(this._namingProp), e || (e = c), b[e] = !0, this._orderedRegions.push(e), this._regions[e] && this._regions[e].domElement() === a || (this._regions[e] = this._fixtureTest(a) ? new ContentEdit.Fixture(a) : new ContentEdit.Region(a), this._regionsLastModified[e] = this._regions[e].lastModified());
				j = this._regions, k = [];
				for (e in j) f = j[e], b[e] || (delete this._regions[e], delete this._regionsLastModified[e], d = this._orderedRegions.indexOf(e), k.push(d > -1 ? this._orderedRegions.splice(d, 1) : void 0));
				return k
			}, c
		}(b.ComponentUI), b.EditorApp = function () {
			function a() {}
			var c;
			return c = null, a.get = function () {
				var a;
				return a = b.EditorApp.getCls(), null != c ? c : c = new a
			}, a.getCls = function () {
				return f
			}, a
		}(), b.History = function () {
			function a(a) {
				this._lastSnapshotTaken = null, this._regions = {}, this.replaceRegions(a), this._snapshotIndex = -1, this._snapshots = [], this._store()
			}
			return a.prototype.canRedo = function () {
				return this._snapshotIndex < this._snapshots.length - 1
			}, a.prototype.canUndo = function () {
				return this._snapshotIndex > 0
			}, a.prototype.index = function () {
				return this._snapshotIndex
			}, a.prototype.length = function () {
				return this._snapshots.length
			}, a.prototype.snapshot = function () {
				return this._snapshots[this._snapshotIndex]
			}, a.prototype.goTo = function (a) {
				return this._snapshotIndex = Math.min(this._snapshots.length - 1, Math.max(0, a)), this.snapshot()
			}, a.prototype.redo = function () {
				return this.goTo(this._snapshotIndex + 1)
			}, a.prototype.replaceRegions = function (a) {
				var b, c, d;
				this._regions = {}, d = [];
				for (b in a) c = a[b], d.push(this._regions[b] = c);
				return d
			}, a.prototype.restoreSelection = function (a) {
				var b, c;
				if (a.selected) return c = this._regions[a.selected.region], b = c.descendants()[a.selected.element], b.focus(), b.selection && a.selected.selection ? b.selection(a.selected.selection) : void 0
			}, a.prototype.stopWatching = function () {
				return this._watchInterval && clearInterval(this._watchInterval), this._delayedStoreTimeout ? clearTimeout(this._delayedStoreTimeout) : void 0
			}, a.prototype.undo = function () {
				return this.goTo(this._snapshotIndex - 1)
			}, a.prototype.watch = function () {
				var a;
				return this._lastSnapshotTaken = Date.now(), a = function (a) {
					return function () {
						var b, c;
						if (c = ContentEdit.Root.get().lastModified(), null !== c && c > a._lastSnapshotTaken) {
							if (a._delayedStoreRequested === c) return;
							return a._delayedStoreTimeout && clearTimeout(a._delayedStoreTimeout), b = function () {
								return a._lastSnapshotTaken = c, a._store()
							}, a._delayedStoreRequested = c, a._delayedStoreTimeout = setTimeout(b, 500)
						}
					}
				}(this), this._watchInterval = setInterval(a, 50)
			}, a.prototype._store = function () {
				var a, b, c, d, e, f, g;
				e = {
					regions: {},
					selected: null
				}, f = this._regions;
				for (b in f) d = f[b], e.regions[b] = d.html();
				if (a = ContentEdit.Root.get().focused()) {
					if (e.selected = {}, d = a.closest(function (a) {
							return "Region" === a.type() || "Fixture" === a.type()
						}), !d) return;
					g = this._regions;
					for (b in g)
						if (c = g[b], d === c) {
							e.selected.region = b;
							break
						}
					e.selected.element = d.descendants().indexOf(a), a.selection && (e.selected.selection = a.selection())
				}
				return this._snapshotIndex < this._snapshots.length - 1 && (this._snapshots = this._snapshots.slice(0, this._snapshotIndex + 1)), this._snapshotIndex++, this._snapshots.splice(this._snapshotIndex, 0, e)
			}, a
		}(), b.StylePalette = function () {
			function a() {}
			return a._styles = [], a.add = function (a) {
				return this._styles = this._styles.concat(a)
			}, a.styles = function (a) {
				var b;
				return b = a.tagName(), void 0 === a ? this._styles.slice() : this._styles.filter(function (a) {
					return a._applicableTo ? -1 !== a._applicableTo.indexOf(b) : !0
				})
			}, a
		}(), b.Style = function () {
			function a(a, b, c) {
				this._name = a, this._cssClass = b, this._applicableTo = c ? c : null
			}
			return a.prototype.applicableTo = function () {
				return this._applicableTo
			}, a.prototype.cssClass = function () {
				return this._cssClass
			}, a.prototype.name = function () {
				return this._name
			}, a
		}(), b.ToolShelf = function () {
			function a() {}
			return a._tools = {}, a.stow = function (a, b) {
				return this._tools[b] = a
			}, a.fetch = function (a) {
				if (!this._tools[a]) throw new Error("`" + a + "` has not been stowed on the tool shelf");
				return this._tools[a]
			}, a
		}(), b.Tool = function () {
			function a() {}
			return a.label = "Tool", a.icon = "tool", a.requiresElement = !0, a.canApply = function () {
				return !1
			}, a.isApplied = function () {
				return !1
			}, a.apply = function () {
				throw new Error("Not implemented")
			}, a._insertAt = function (a) {
				var b, c;
				return c = a, "Region" !== c.parent().type() && (c = a.closest(function (a) {
					return "Region" === a.parent().type()
				})), b = c.parent().children.indexOf(c) + 1, [c, b]
			}, a
		}(), b.Tools.Bold = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "bold"), c.label = "Bold", c.icon = "bold", c.tagName = "b", c.canApply = function (a, b) {
				return a.content ? b && !b.isCollapsed() : !1
			}, c.isApplied = function (a, b) {
				var c, d, e;
				return void 0 !== a.content && a.content.length() ? (e = b.get(), c = e[0], d = e[1], c === d && (d += 1), a.content.slice(c, d).hasTags(this.tagName, !0)) : !1
			}, c.apply = function (a, b, c) {
				var d, e, f;
				return a.storeState(), f = b.get(), d = f[0], e = f[1], a.content = this.isApplied(a, b) ? a.content.unformat(d, e, new HTMLString.Tag(this.tagName)) : a.content.format(d, e, new HTMLString.Tag(this.tagName)), a.content.optimize(), a.updateInnerHTML(), a.taint(), a.restoreState(), c(!0)
			}, c
		}(b.Tool), b.Tools.Italic = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "italic"), c.label = "Italic", c.icon = "italic", c.tagName = "i", c
		}(b.Tools.Bold), b.Tools.Link = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "link"), c.label = "Link", c.icon = "link", c.tagName = "a", c.getAttr = function (a, b, c) {
				var d, e, f, g, h, i, j, k, l, m, n, o;
				if ("Image" === b.type()) {
					if (b.a) return b.a[a]
				} else
					for (m = c.get(), e = m[0], h = m[1], f = b.content.slice(e, h), n = f.characters, i = 0, k = n.length; k > i; i++)
						if (d = n[i], d.hasTags("a"))
							for (o = d.tags(), j = 0, l = o.length; l > j; j++)
								if (g = o[j], "a" === g.name()) return g.attr(a); return ""
			}, c.canApply = function (a, b) {
				var c;
				return "Image" === a.type() ? !0 : a.content && b && (!b.isCollapsed() || (c = a.content.characters[b.get()[0]], c && c.hasTags("a"))) ? !0 : !1
			}, c.isApplied = function (a, b) {
				return "Image" === a.type() ? a.a : c.__super__.constructor.isApplied.call(this, a, b)
			}, c.apply = function (a, c, d) {
				var e, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w;
				if (g = !1, "Image" === a.type()) o = a.domElement().getBoundingClientRect();
				else {
					if (c.isCollapsed()) {
						for (h = a.content.characters, s = c.get(0)[0], k = s; s > 0 && h[s - 1].hasTags("a");) s -= 1;
						for (; k < h.length && h[k].hasTags("a");) k += 1;
						c = new ContentSelect.Range(s, k), c.select(a.domElement())
					}
					a.storeState(), r = new HTMLString.Tag("span", {
						"class": "ct--puesdo-select"
					}), v = c.get(), l = v[0], t = v[1], a.content = a.content.format(l, t, r), a.updateInnerHTML(), j = a.domElement(), m = j.getElementsByClassName("ct--puesdo-select"), o = m[0].getBoundingClientRect()
				}
				return f = b.EditorApp.get(), n = new b.ModalUI(u = !0, e = !0), n.addEventListener("click", function () {
					return this.unmount(), i.hide(), a.content && (a.content = a.content.unformat(l, t, r), a.updateInnerHTML(), a.restoreState()), d(g)
				}), i = new b.LinkDialog(this.getAttr("href", a, c), this.getAttr("target", a, c)), w = b.getScrollPosition(), p = w[0], q = w[1], i.position([o.left + o.width / 2 + p, o.top + o.height / 2 + q]), i.addEventListener("save", function (b) {
					var c, d, e, f, h, i, j, k, m;
					if (f = b.detail(), g = !0, "Image" === a.type()) {
						if (d = ["align-center", "align-left", "align-right"], f.href) {
							for (a.a = {
									href: f.href
								}, a.a && (a.a["class"] = a.a["class"]), f.target && (a.a.target = f.target), i = 0, k = d.length; k > i; i++)
								if (e = d[i], a.hasCSSClass(e)) {
									a.removeCSSClass(e), a.a["class"] = e;
									break
								}
						} else {
							for (h = [], a.a["class"] && (h = a.a["class"].split(" ")), j = 0, m = d.length; m > j; j++)
								if (e = d[j], h.indexOf(e) > -1) {
									a.addCSSClass(e);
									break
								}
							a.a = null
						}
						a.unmount(), a.mount()
					} else a.content = a.content.unformat(l, t, "a"), f.href && (c = new HTMLString.Tag("a", f), a.content = a.content.format(l, t, c), a.content.optimize()), a.updateInnerHTML();
					return a.taint(), n.dispatchEvent(n.createEvent("click"))
				}), f.attach(n), f.attach(i), n.show(), i.show()
			}, c
		}(b.Tools.Bold), b.Tools.Heading = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "heading"), c.label = "Heading", c.icon = "heading", c.tagName = "h1", c.canApply = function (a) {
				return a.isFixed() ? !1 : void 0 !== a.content && -1 !== ["Text", "PreText"].indexOf(a.type())
			}, c.isApplied = function (a) {
				return a.content ? -1 === ["Text", "PreText"].indexOf(a.type()) ? !1 : a.tagName() === this.tagName : !1
			}, c.apply = function (a, b, c) {
				var d, e, f, g;
				return a.storeState(), "PreText" === a.type() ? (d = a.content.html().replace(/&nbsp;/g, " "), g = new ContentEdit.Text(this.tagName, {}, d), f = a.parent(), e = f.children.indexOf(a), f.detach(a), f.attach(g, e), a.blur(), g.focus(), g.selection(b)) : (a.removeAttr("class"), a.tagName(a.tagName() === this.tagName ? "p" : this.tagName), a.restoreState()), c(!0)
			}, c
		}(b.Tool), b.Tools.Subheading = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "subheading"), c.label = "Subheading", c.icon = "subheading", c.tagName = "h2", c
		}(b.Tools.Heading), b.Tools.Paragraph = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "paragraph"), c.label = "Paragraph", c.icon = "paragraph", c.tagName = "p", c.canApply = function (a) {
				return a.isFixed() ? !1 : void 0 !== a
			}, c.apply = function (a, d, e) {
				var f, g, h, i;
				return f = b.EditorApp.get(), g = f.ctrlDown(), b.Tools.Heading.canApply(a) && !g ? c.__super__.constructor.apply.call(this, a, d, e) : ("Region" !== a.parent().type() && (a = a.closest(function (a) {
					return "Region" === a.parent().type()
				})), i = a.parent(), h = new ContentEdit.Text("p"), i.attach(h, i.children.indexOf(a) + 1), h.focus(), e(!0))
			}, c
		}(b.Tools.Heading), b.Tools.Preformatted = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "preformatted"), c.label = "Preformatted", c.icon = "preformatted", c.tagName = "pre", c.apply = function (a, c, d) {
				var e, f, g, h;
				return "PreText" === a.type() ? void b.Tools.Paragraph.apply(a, c, d) : (h = a.content.text(), g = new ContentEdit.PreText("pre", {}, HTMLString.String.encode(h)), f = a.parent(), e = f.children.indexOf(a), f.detach(a), f.attach(g, e), a.blur(), g.focus(), g.selection(c), d(!0))
			}, c
		}(b.Tools.Heading), b.Tools.AlignLeft = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "align-left"), c.label = "Align left", c.icon = "align-left", c.className = "text-left", c.canApply = function (a) {
				return void 0 !== a.content
			}, c.isApplied = function (a) {
				var b;
				return this.canApply(a) ? (("ListItemText" === (b = a.type()) || "TableCellText" === b) && (a = a.parent()), a.hasCSSClass(this.className)) : !1
			}, c.apply = function (a, c, d) {
				var e, f, g, h, i;
				for (("ListItemText" === (i = a.type()) || "TableCellText" === i) && (a = a.parent()), e = [b.Tools.AlignLeft.className, b.Tools.AlignCenter.className, b.Tools.AlignRight.className], g = 0, h = e.length; h > g; g++)
					if (f = e[g], a.hasCSSClass(f) && (a.removeCSSClass(f), f === this.className)) return d(!0);
				return a.addCSSClass(this.className), d(!0)
			}, c
		}(b.Tool), b.Tools.AlignCenter = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "align-center"), c.label = "Align center", c.icon = "align-center", c.className = "text-center", c
		}(b.Tools.AlignLeft), b.Tools.AlignRight = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "align-right"), c.label = "Align right", c.icon = "align-right", c.className = "text-right", c
		}(b.Tools.AlignLeft), b.Tools.UnorderedList = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "unordered-list"), c.label = "Bullet list", c.icon = "unordered-list", c.listTag = "ul", c.canApply = function (a) {
				var b;
				return a.isFixed() ? !1 : void 0 !== a.content && ("Region" === (b = a.parent().type()) || "ListItem" === b)
			}, c.apply = function (a, b, c) {
				var d, e, f, g, h;
				return "ListItem" === a.parent().type() ? (a.storeState(), e = a.closest(function (a) {
					return "List" === a.type()
				}), e.tagName(this.listTag), a.restoreState()) : (g = new ContentEdit.ListItemText(a.content.copy()), f = new ContentEdit.ListItem, f.attach(g), e = new ContentEdit.List(this.listTag, {}), e.attach(f), h = a.parent(), d = h.children.indexOf(a), h.detach(a), h.attach(e, d), g.focus(), g.selection(b)), c(!0)
			}, c
		}(b.Tool), b.Tools.OrderedList = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "ordered-list"), c.label = "Numbers list", c.icon = "ordered-list", c.listTag = "ol", c
		}(b.Tools.UnorderedList), b.Tools.Table = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "table"), c.label = "Table", c.icon = "table", c.canApply = function (a) {
				return a.isFixed() ? !1 : void 0 !== a
			}, c.apply = function (a, c, d) {
				var e, f, g, h;
				return a.storeState && a.storeState(), e = b.EditorApp.get(), g = new b.ModalUI, h = a.closest(function (a) {
					return a && "Table" === a.type()
				}), f = new b.TableDialog(h), f.addEventListener("cancel", function () {
					return function () {
						return g.hide(), f.hide(), a.restoreState && a.restoreState(), d(!1)
					}
				}(this)), f.addEventListener("save", function (b) {
					return function (c) {
						var e, i, j, k, l;
						return k = c.detail(), i = !0, h ? (b._updateTable(k, h), i = a.closest(function (a) {
							return a && "Table" === a.type()
						})) : (h = b._createTable(k), l = b._insertAt(a), j = l[0], e = l[1], j.parent().attach(h, e), i = !1), i ? a.restoreState() : h.firstSection().children[0].children[0].children[0].focus(), g.hide(), f.hide(), d(!0)
					}
				}(this)), e.attach(g), e.attach(f), g.show(), f.show()
			}, c._adjustColumns = function (a, b) {
				var c, d, e, f, g, h, i, j, k, l, m;
				for (l = a.children, m = [], j = 0, k = l.length; k > j; j++) i = l[j], d = i.children[0].tagName(), f = i.children.length, g = b - f, m.push(0 > g ? function () {
					var a, b;
					for (b = [], h = a = g; 0 >= g ? 0 > a : a > 0; h = 0 >= g ? ++a : --a) c = i.children[i.children.length - 1], b.push(i.detach(c));
					return b
				}() : g > 0 ? function () {
					var a, b;
					for (b = [], h = a = 0; g >= 0 ? g > a : a > g; h = g >= 0 ? ++a : --a) c = new ContentEdit.TableCell(d), i.attach(c), e = new ContentEdit.TableCellText(""), b.push(c.attach(e));
					return b
				}() : void 0);
				return m
			}, c._createTable = function (a) {
				var b, c, d, e;
				return e = new ContentEdit.Table, a.head && (d = this._createTableSection("thead", "th", a.columns), e.attach(d)), b = this._createTableSection("tbody", "td", a.columns), e.attach(b), a.foot && (c = this._createTableSection("tfoot", "td", a.columns), e.attach(c)), e
			}, c._createTableSection = function (a, b, c) {
				var d, e, f, g, h, i;
				for (h = new ContentEdit.TableSection(a), g = new ContentEdit.TableRow, h.attach(g), f = i = 0; c >= 0 ? c > i : i > c; f = c >= 0 ? ++i : --i) d = new ContentEdit.TableCell(b), g.attach(d), e = new ContentEdit.TableCellText(""), d.attach(e);
				return h
			}, c._updateTable = function (a, b) {
				var c, d, e, f, g, h, i;
				if (!a.head && b.thead() && b.detach(b.thead()), !a.foot && b.tfoot() && b.detach(b.tfoot()), c = b.firstSection().children[0].children.length, a.columns !== c)
					for (i = b.children, g = 0, h = i.length; h > g; g++) f = i[g], this._adjustColumns(f, a.columns);
				return a.head && !b.thead() && (e = this._createTableSection("thead", "th", a.columns), b.attach(e)), a.foot && !b.tfoot() ? (d = this._createTableSection("tfoot", "td", a.columns), b.attach(d)) : void 0
			}, c
		}(b.Tool), b.Tools.Indent = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "indent"), c.label = "Indent", c.icon = "indent", c.canApply = function (a) {
				return "ListItem" === a.parent().type() && a.parent().parent().children.indexOf(a.parent()) > 0
			}, c.apply = function (a, b, c) {
				return a.parent().indent(), c(!0)
			}, c
		}(b.Tool), b.Tools.Unindent = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "unindent"), c.label = "Unindent", c.icon = "unindent", c.canApply = function (a) {
				return "ListItem" === a.parent().type()
			}, c.apply = function (a, b, c) {
				return a.parent().unindent(), c(!0)
			}, c
		}(b.Tool), b.Tools.LineBreak = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "line-break"), c.label = "Line break", c.icon = "line-break", c.canApply = function (a) {
				return a.content
			}, c.apply = function (a, b, c) {
				var d, e, f, g;
				return e = b.get()[0] + 1, g = a.content.substring(0, b.get()[0]), f = a.content.substring(b.get()[1]), d = new HTMLString.String("<br>", a.content.preserveWhitespace()), a.content = g.concat(d, f), a.updateInnerHTML(), a.taint(), b.set(e, e), a.selection(b), c(!0)
			}, c
		}(b.Tool), b.Tools.Image = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "image"), c.label = "Image", c.icon = "image", c.canApply = function (a) {
				return !a.isFixed()
			}, c.apply = function (a, c, d) {
				var e, f, g;
				return a.storeState && a.storeState(), e = b.EditorApp.get(), g = new b.ModalUI, f = new b.ImageDialog, f.addEventListener("cancel", function () {
					return function () {
						return g.hide(), f.hide(), a.restoreState && a.restoreState(), d(!1)
					}
				}(this)), f.addEventListener("save", function (b) {
					return function (c) {
						var e, h, i, j, k, l, m, n;
						return e = c.detail(), k = e.imageURL, j = e.imageSize, i = e.imageAttrs, i || (i = {}), i.height = j[1], i.src = k, i.width = j[0], h = new ContentEdit.Image(i), n = b._insertAt(a), m = n[0], l = n[1], m.parent().attach(h, l), h.focus(), g.hide(), f.hide(), d(!0)
					}
				}(this)), e.attach(g), e.attach(f), g.show(), f.show()
			}, c
		}(b.Tool), b.Tools.Video = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "video"), c.label = "Video", c.icon = "video", c.canApply = function (a) {
				return !a.isFixed()
			}, c.apply = function (a, c, d) {
				var e, f, g;
				return a.storeState && a.storeState(), e = b.EditorApp.get(), g = new b.ModalUI, f = new b.VideoDialog, f.addEventListener("cancel", function () {
					return function () {
						return g.hide(), f.hide(), a.restoreState && a.restoreState(), d(!1)
					}
				}(this)), f.addEventListener("save", function (c) {
					return function (e) {
						var h, i, j, k, l;
						return j = e.detail().url, j ? (k = new ContentEdit.Video("iframe", {
							frameborder: 0,
							height: b.DEFAULT_VIDEO_HEIGHT,
							src: j,
							width: b.DEFAULT_VIDEO_WIDTH
						}), l = c._insertAt(a), i = l[0], h = l[1], i.parent().attach(k, h), k.focus()) : a.restoreState && a.restoreState(), g.hide(), f.hide(), d("" !== j)
					}
				}(this)), e.attach(g), e.attach(f), g.show(), f.show()
			}, c
		}(b.Tool), b.Tools.Undo = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "undo"), c.label = "Undo", c.icon = "undo", c.requiresElement = !1, c.canApply = function () {
				var a;
				return a = b.EditorApp.get(), a.history && a.history.canUndo()
			}, c.apply = function () {
				var a, c;
				return a = b.EditorApp.get(), a.history.stopWatching(), c = a.history.undo(), a.revertToSnapshot(c), a.history.watch()
			}, c
		}(b.Tool), b.Tools.Redo = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "redo"), c.label = "Redo", c.icon = "redo", c.requiresElement = !1, c.canApply = function () {
				var a;
				return a = b.EditorApp.get(), a.history && a.history.canRedo()
			}, c.apply = function () {
				var a, c;
				return a = b.EditorApp.get(), a.history.stopWatching(), c = a.history.redo(), a.revertToSnapshot(c), a.history.watch()
			}, c
		}(b.Tool), b.Tools.Remove = function (a) {
			function c() {
				return c.__super__.constructor.apply(this, arguments)
			}
			return h(c, a), b.ToolShelf.stow(c, "remove"), c.label = "Remove", c.icon = "remove", c.canApply = function (a) {
				return !a.isFixed()
			}, c.apply = function (a, c, d) {
				var e, f, g, h;
				if (e = b.EditorApp.get(), a.blur(), a.nextContent() ? a.nextContent().focus() : a.previousContent() && a.previousContent().focus(), !a.isMounted()) return void d(!0);
				switch (a.type()) {
				case "ListItemText":
					e.ctrlDown() ? (f = a.closest(function (a) {
						return "Region" === a.parent().type()
					}), f.parent().detach(f)) : a.parent().parent().detach(a.parent());
					break;
				case "TableCellText":
					e.ctrlDown() ? (h = a.closest(function (a) {
						return "Table" === a.type()
					}), h.parent().detach(h)) : (g = a.parent().parent(), g.parent().detach(g));
					break;
				default:
					a.parent().detach(a)
				}
				return d(!0)
			}, c
		}(b.Tool)
	}.call(this);