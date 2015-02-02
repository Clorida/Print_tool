svgedit = {
    NS: {
        HTML: "http://www.w3.org/1999/xhtml",
        MATH: "http://www.w3.org/1998/Math/MathML",
        SE: "http://svg-edit.googlecode.com",
        SVG: "http://www.w3.org/2000/svg",
        XLINK: "http://www.w3.org/1999/xlink",
        XML: "http://www.w3.org/XML/1998/namespace",
        XMLNS: "http://www.w3.org/2000/xmlns/"
    }
};
svgedit.getReverseNS = function() {
    var a = {};
    $.each(this.NS, function(I, o) {
        a[o] = I.toLowerCase()
    });
    return a
};
(function() {
    var a = jQuery.fn.attr;
    jQuery.fn.attr = function(I, o) {
        var c, i = this.length;
        if (!i) return a.apply(this, arguments);
        for (c = 0; c < i; ++c) {
            var s = this[c];
            if (s.namespaceURI === "http://www.w3.org/2000/svg") {
                if (o !== undefined) s.setAttribute(I, o);
                else if ($.isArray(I)) {
                    i = I.length;
                    for (var e = {}; i--;) {
                        var g = I[i];
                        if ((c = s.getAttribute(g)) || c === "0") c = isNaN(c) ? c : c - 0;
                        e[g] = c
                    }
                    return e
                }
                if (typeof I === "object")
                    for (e in I) s.setAttribute(e, I[e]);
                else {
                    if ((c = s.getAttribute(I)) || c === "0") c = isNaN(c) ? c : c - 0;
                    return c
                }
            } else return a.apply(this,
                arguments)
        }
        return this
    }
})();
jQuery && function() {
    var a = $(window),
        I = $(document);
    $.extend($.fn, {
        contextMenu: function(o, c) {
            if (o.menu == undefined) return false;
            if (o.inSpeed == undefined) o.inSpeed = 150;
            if (o.outSpeed == undefined) o.outSpeed = 75;
            if (o.inSpeed == 0) o.inSpeed = -1;
            if (o.outSpeed == 0) o.outSpeed = -1;
            $(this).each(function() {
                var i = $(this),
                    s = $(i).offset(),
                    e = $("#" + o.menu);
                e.addClass("contextMenu");
                $(this).bind("mousedown", function(g) {
                    $(this).mouseup(function(q) {
                        var w = $(this);
                        w.unbind("mouseup");
                        if (g.button === 2 || o.allowLeft || g.ctrlKey && svgedit.browser.isMac()) {
                            q.stopPropagation();
                            $(".contextMenu").hide();
                            if (i.hasClass("disabled")) return false;
                            var D = q.pageX,
                                u = q.pageY;
                            q = a.width() - e.width();
                            var A = a.height() - e.height();
                            if (D > q - 15) D = q - 15;
                            if (u > A - 30) u = A - 30;
                            I.unbind("click");
                            e.css({
                                top: u,
                                left: D
                            }).fadeIn(o.inSpeed);
                            e.find("A").mouseover(function() {
                                e.find("LI.hover").removeClass("hover");
                                $(this).parent().addClass("hover")
                            }).mouseout(function() {
                                e.find("LI.hover").removeClass("hover")
                            });
                            I.keypress(function(p) {
                                switch (p.keyCode) {
                                    case 38:
                                        if (e.find("LI.hover").length) {
                                            e.find("LI.hover").removeClass("hover").prevAll("LI:not(.disabled)").eq(0).addClass("hover");
                                            e.find("LI.hover").length || e.find("LI:last").addClass("hover")
                                        } else e.find("LI:last").addClass("hover");
                                        break;
                                    case 40:
                                        if (e.find("LI.hover").length == 0) e.find("LI:first").addClass("hover");
                                        else {
                                            e.find("LI.hover").removeClass("hover").nextAll("LI:not(.disabled)").eq(0).addClass("hover");
                                            e.find("LI.hover").length || e.find("LI:first").addClass("hover")
                                        }
                                        break;
                                    case 13:
                                        e.find("LI.hover A").trigger("click");
                                        break;
                                    case 27:
                                        I.trigger("click")
                                }
                            });
                            e.find("A").unbind("mouseup");
                            e.find("LI:not(.disabled) A").mouseup(function() {
                                I.unbind("click").unbind("keypress");
                                $(".contextMenu").hide();
                                c && c($(this).attr("href").substr(1), $(w), {
                                    x: D - s.left,
                                    y: u - s.top,
                                    docX: D,
                                    docY: u
                                });
                                return false
                            });
                            setTimeout(function() {
                                I.click(function() {
                                    I.unbind("click").unbind("keypress");
                                    e.fadeOut(o.outSpeed);
                                    return false
                                })
                            }, 0)
                        }
                    })
                });
                if ($.browser.mozilla) $("#" + o.menu).each(function() {
                    $(this).css({
                        MozUserSelect: "none"
                    })
                });
                else $.browser.msie ? $("#" + o.menu).each(function() {
                    $(this).bind("selectstart.disableTextSelect", function() {
                        return false
                    })
                }) : $("#" + o.menu).each(function() {
                    $(this).bind("mousedown.disableTextSelect",
                        function() {
                            return false
                        })
                });
                $(i).add($("UL.contextMenu")).bind("contextmenu", function() {
                    return false
                })
            });
            return $(this)
        },
        disableContextMenuItems: function(o) {
            if (o == undefined) {
                $(this).find("LI").addClass("disabled");
                return $(this)
            }
            $(this).each(function() {
                if (o != undefined)
                    for (var c = o.split(","), i = 0; i < c.length; i++) $(this).find('A[href="' + c[i] + '"]').parent().addClass("disabled")
            });
            return $(this)
        },
        enableContextMenuItems: function(o) {
            if (o == undefined) {
                $(this).find("LI.disabled").removeClass("disabled");
                return $(this)
            }
            $(this).each(function() {
                if (o !=
                    undefined)
                    for (var c = o.split(","), i = 0; i < c.length; i++) $(this).find('A[href="' + c[i] + '"]').parent().removeClass("disabled")
            });
            return $(this)
        },
        disableContextMenu: function() {
            $(this).each(function() {
                $(this).addClass("disabled")
            });
            return $(this)
        },
        enableContextMenu: function() {
            $(this).each(function() {
                $(this).removeClass("disabled")
            });
            return $(this)
        },
        destroyContextMenu: function() {
            $(this).each(function() {
                $(this).unbind("mousedown").unbind("mouseup")
            });
            return $(this)
        }
    })
}(jQuery);
(function() {
    if (!svgedit.browser) svgedit.browser = {};
    var a = svgedit.NS,
        I = !!document.createElementNS && !!document.createElementNS(a.SVG, "svg").createSVGRect;
    svgedit.browser.supportsSvg = function() {
        return I
    };
    if (svgedit.browser.supportsSvg()) {
        var o = navigator.userAgent,
            c = document.createElementNS(a.SVG, "svg"),
            i = !!window.opera,
            s = o.indexOf("AppleWebKit") >= 0,
            e = o.indexOf("Gecko/") >= 0,
            g = o.indexOf("MSIE") >= 0,
            q = o.indexOf("Chrome/") >= 0,
            w = o.indexOf("Windows") >= 0,
            D = o.indexOf("Macintosh") >= 0,
            u = "ontouchstart" in window,
            A = !!c.querySelector,
            p = !!document.evaluate,
            v = function() {
                var ea = document.createElementNS(a.SVG, "path");
                ea.setAttribute("d", "M0,0 10,10");
                var ka = ea.pathSegList;
                ea = ea.createSVGPathSegLinetoAbs(5, 5);
                try {
                    ka.replaceItem(ea, 0);
                    return true
                } catch (Ia) {}
                return false
            }(),
            t = function() {
                var ea = document.createElementNS(a.SVG, "path");
                ea.setAttribute("d", "M0,0 10,10");
                var ka = ea.pathSegList;
                ea = ea.createSVGPathSegLinetoAbs(5, 5);
                try {
                    ka.insertItemBefore(ea, 0);
                    return true
                } catch (Ia) {}
                return false
            }(),
            m = function() {
                var ea = document.createElementNS(a.SVG,
                        "svg"),
                    ka = document.createElementNS(a.SVG, "svg");
                document.documentElement.appendChild(ea);
                ka.setAttribute("x", 5);
                ea.appendChild(ka);
                var Ia = document.createElementNS(a.SVG, "text");
                Ia.textContent = "a";
                ka.appendChild(Ia);
                ka = Ia.getStartPositionOfChar(0).x;
                document.documentElement.removeChild(ea);
                return ka === 0
            }(),
            L = function() {
                var ea = document.createElementNS(a.SVG, "svg");
                document.documentElement.appendChild(ea);
                var ka = document.createElementNS(a.SVG, "path");
                ka.setAttribute("d", "M0,0 C0,0 10,10 10,0");
                ea.appendChild(ka);
                ka = ka.getBBox();
                document.documentElement.removeChild(ea);
                return ka.height > 4 && ka.height < 5
            }(),
            R = function() {
                var ea = document.createElementNS(a.SVG, "svg");
                document.documentElement.appendChild(ea);
                var ka = document.createElementNS(a.SVG, "path");
                ka.setAttribute("d", "M0,0 10,0");
                var Ia = document.createElementNS(a.SVG, "path");
                Ia.setAttribute("d", "M5,0 15,0");
                var Ba = document.createElementNS(a.SVG, "g");
                Ba.appendChild(ka);
                Ba.appendChild(Ia);
                ea.appendChild(Ba);
                ka = Ba.getBBox();
                document.documentElement.removeChild(ea);
                return ka.width == 15
            }(),
            da = function() {
                var ea = document.createElementNS(a.SVG, "rect");
                ea.setAttribute("x", 0.1);
                (ea = ea.cloneNode(false).getAttribute("x").indexOf(",") == -1) || $.alert('NOTE: This version of Opera is known to contain bugs in SVG-edit.\nPlease upgrade to the <a href="http://opera.com">latest version</a> in which the problems have been fixed.');
                return ea
            }(),
            qa = function() {
                var ea = document.createElementNS(a.SVG, "rect");
                ea.setAttribute("style", "vector-effect:non-scaling-stroke");
                return ea.style.vectorEffect ===
                    "non-scaling-stroke"
            }(),
            fa = function() {
                var ea = document.createElementNS(a.SVG, "rect").transform.baseVal,
                    ka = c.createSVGTransform();
                ea.appendItem(ka);
                return ea.getItem(0) == ka
            }();
        svgedit.browser.isOpera = function() {
            return i
        };
        svgedit.browser.isWebkit = function() {
            return s
        };
        svgedit.browser.isGecko = function() {
            return e
        };
        svgedit.browser.isIE = function() {
            return g
        };
        svgedit.browser.isChrome = function() {
            return q
        };
        svgedit.browser.isWindows = function() {
            return w
        };
        svgedit.browser.isMac = function() {
            return D
        };
        svgedit.browser.isTouch =
            function() {
                return u
            };
        svgedit.browser.supportsSelectors = function() {
            return A
        };
        svgedit.browser.supportsXpath = function() {
            return p
        };
        svgedit.browser.supportsPathReplaceItem = function() {
            return v
        };
        svgedit.browser.supportsPathInsertItemBefore = function() {
            return t
        };
        svgedit.browser.supportsPathBBox = function() {
            return L
        };
        svgedit.browser.supportsHVLineContainerBBox = function() {
            return R
        };
        svgedit.browser.supportsGoodTextCharPos = function() {
            return m
        };
        svgedit.browser.supportsEditableText = function() {
            return i
        };
        svgedit.browser.supportsGoodDecimals =
            function() {
                return da
            };
        svgedit.browser.supportsNonScalingStroke = function() {
            return qa
        };
        svgedit.browser.supportsNativeTransformLists = function() {
            return fa
        }
    } else window.location = "browser-not-supported.html"
})();
(function() {
    if (!svgedit.transformlist) svgedit.transformlist = {};
    var a = document.createElementNS(svgedit.NS.SVG, "svg"),
        I = {};
    svgedit.transformlist.SVGTransformList = function(o) {
        this._elem = o || null;
        this._xforms = [];
        this._update = function() {
            var c = "";
            a.createSVGMatrix();
            var i;
            for (i = 0; i < this.numberOfItems; ++i) {
                var s = this._list.getItem(i);
                c = c;
                s = s;
                var e = s.matrix,
                    g = "";
                switch (s.type) {
                    case 1:
                        g = "matrix(" + [e.a, e.b, e.c, e.d, e.e, e.f].join(",") + ")";
                        break;
                    case 2:
                        g = "translate(" + e.e + "," + e.f + ")";
                        break;
                    case 3:
                        g = e.a == e.d ? "scale(" +
                            e.a + ")" : "scale(" + e.a + "," + e.d + ")";
                        break;
                    case 4:
                        var q = 0;
                        g = 0;
                        if (s.angle != 0) {
                            q = 1 - e.a;
                            g = (q * e.f + e.b * e.e) / (q * q + e.b * e.b);
                            q = (e.e - e.b * g) / q
                        }
                        g = "rotate(" + s.angle + " " + q + "," + g + ")"
                }
                c = c + (g + " ")
            }
            this._elem.setAttribute("transform", c)
        };
        this._list = this;
        this._init = function() {
            var c = this._elem.getAttribute("transform");
            if (c)
                for (var i = /\s*((scale|matrix|rotate|translate)\s*\(.*?\))\s*,?\s*/, s = true; s;) {
                    s = c.match(i);
                    c = c.replace(i, "");
                    if (s && s[1]) {
                        var e = s[1].split(/\s*\(/),
                            g = e[0];
                        e = e[1].match(/\s*(.*?)\s*\)/);
                        e[1] = e[1].replace(/(\d)-/g,
                            "$1 -");
                        var q = e[1].split(/[, ]+/),
                            w = "abcdef".split(""),
                            D = a.createSVGMatrix();
                        $.each(q, function(p, v) {
                            q[p] = parseFloat(v);
                            if (g == "matrix") D[w[p]] = q[p]
                        });
                        e = a.createSVGTransform();
                        var u = "set" + g.charAt(0).toUpperCase() + g.slice(1),
                            A = g == "matrix" ? [D] : q;
                        if (g == "scale" && A.length == 1) A.push(A[0]);
                        else if (g == "translate" && A.length == 1) A.push(0);
                        else g == "rotate" && A.length == 1 && A.push(0, 0);
                        e[u].apply(e, A);
                        this._list.appendItem(e)
                    }
                }
        };
        this._removeFromOtherLists = function(c) {
            if (c) {
                var i = false,
                    s;
                for (s in I) {
                    var e = I[s],
                        g, q;
                    g = 0;
                    for (q = e._xforms.length; g < q; ++g)
                        if (e._xforms[g] == c) {
                            i = true;
                            e.removeItem(g);
                            break
                        }
                    if (i) break
                }
            }
        };
        this.numberOfItems = 0;
        this.clear = function() {
            this.numberOfItems = 0;
            this._xforms = []
        };
        this.initialize = function(c) {
            this.numberOfItems = 1;
            this._removeFromOtherLists(c);
            this._xforms = [c]
        };
        this.getItem = function(c) {
            if (c < this.numberOfItems && c >= 0) return this._xforms[c];
            throw {
                code: 1
            };
        };
        this.insertItemBefore = function(c, i) {
            var s = null;
            if (i >= 0)
                if (i < this.numberOfItems) {
                    this._removeFromOtherLists(c);
                    s = Array(this.numberOfItems +
                        1);
                    var e;
                    for (e = 0; e < i; ++e) s[e] = this._xforms[e];
                    s[e] = c;
                    var g;
                    for (g = e + 1; e < this.numberOfItems; ++g, ++e) s[g] = this._xforms[e];
                    this.numberOfItems++;
                    this._xforms = s;
                    s = c;
                    this._list._update()
                } else s = this._list.appendItem(c);
            return s
        };
        this.replaceItem = function(c, i) {
            var s = null;
            if (i < this.numberOfItems && i >= 0) {
                this._removeFromOtherLists(c);
                s = this._xforms[i] = c;
                this._list._update()
            }
            return s
        };
        this.removeItem = function(c) {
            if (c < this.numberOfItems && c >= 0) {
                var i = this._xforms[c],
                    s = Array(this.numberOfItems - 1),
                    e;
                for (e = 0; e < c; ++e) s[e] =
                    this._xforms[e];
                for (c = e; c < this.numberOfItems - 1; ++c, ++e) s[c] = this._xforms[e + 1];
                this.numberOfItems--;
                this._xforms = s;
                this._list._update();
                return i
            }
            throw {
                code: 1
            };
        };
        this.appendItem = function(c) {
            this._removeFromOtherLists(c);
            this._xforms.push(c);
            this.numberOfItems++;
            this._list._update();
            return c
        }
    };
    svgedit.transformlist.resetListMap = function() {
        I = {}
    };
    svgedit.transformlist.removeElementFromListMap = function(o) {
        o.id && I[o.id] && delete I[o.id]
    };
    svgedit.transformlist.getTransformList = function(o) {
        if (!svgedit.browser.supportsNativeTransformLists()) {
            var c =
                o.id || "temp",
                i = I[c];
            if (!i || c === "temp") {
                I[c] = new svgedit.transformlist.SVGTransformList(o);
                I[c]._init();
                i = I[c]
            }
            return i
        }
        if (o.transform) return o.transform.baseVal;
        if (o.gradientTransform) return o.gradientTransform.baseVal;
        if (o.patternTransform) return o.patternTransform.baseVal;
        return null
    }
})();
(function() {
    if (!svgedit.math) svgedit.math = {};
    var a = document.createElementNS(svgedit.NS.SVG, "svg");
    svgedit.math.transformPoint = function(I, o, c) {
        return {
            x: c.a * I + c.c * o + c.e,
            y: c.b * I + c.d * o + c.f
        }
    };
    svgedit.math.isIdentity = function(I) {
        return I.a === 1 && I.b === 0 && I.c === 0 && I.d === 1 && I.e === 0 && I.f === 0
    };
    svgedit.math.matrixMultiply = function() {
        for (var I = arguments, o = I.length, c = I[o - 1]; o-- > 1;) c = I[o - 1].multiply(c);
        if (Math.abs(c.a) < 1.0E-14) c.a = 0;
        if (Math.abs(c.b) < 1.0E-14) c.b = 0;
        if (Math.abs(c.c) < 1.0E-14) c.c = 0;
        if (Math.abs(c.d) <
            1.0E-14) c.d = 0;
        if (Math.abs(c.e) < 1.0E-14) c.e = 0;
        if (Math.abs(c.f) < 1.0E-14) c.f = 0;
        return c
    };
    svgedit.math.hasMatrixTransform = function(I) {
        if (!I) return false;
        for (var o = I.numberOfItems; o--;) {
            var c = I.getItem(o);
            if (c.type == 1 && !svgedit.math.isIdentity(c.matrix)) return true
        }
        return false
    };
    svgedit.math.transformBox = function(I, o, c, i, s) {
        var e = svgedit.math.transformPoint,
            g = e(I, o, s),
            q = e(I + c, o, s),
            w = e(I, o + i, s);
        I = e(I + c, o + i, s);
        o = Math.min(g.x, q.x, w.x, I.x);
        c = Math.min(g.y, q.y, w.y, I.y);
        return {
            tl: g,
            tr: q,
            bl: w,
            br: I,
            aabox: {
                x: o,
                y: c,
                width: Math.max(g.x, q.x, w.x, I.x) - o,
                height: Math.max(g.y, q.y, w.y, I.y) - c
            }
        }
    };
    svgedit.math.transformListToTransform = function(I, o, c) {
        if (I == null) return a.createSVGTransformFromMatrix(a.createSVGMatrix());
        o = o || 0;
        c = c || I.numberOfItems - 1;
        o = parseInt(o, 10);
        c = parseInt(c, 10);
        if (o > c) {
            var i = c;
            c = o;
            o = i
        }
        i = a.createSVGMatrix();
        for (o = o; o <= c; ++o) {
            var s = o >= 0 && o < I.numberOfItems ? I.getItem(o).matrix : a.createSVGMatrix();
            i = svgedit.math.matrixMultiply(i, s)
        }
        return a.createSVGTransformFromMatrix(i)
    };
    svgedit.math.getMatrix = function(I) {
        I =
            svgedit.transformlist.getTransformList(I);
        return svgedit.math.transformListToTransform(I).matrix
    };
    svgedit.math.snapToAngle = function(I, o, c, i) {
        var s = Math.PI / 4;
        c = c - I;
        var e = i - o;
        i = Math.sqrt(c * c + e * e);
        s = Math.round(Math.atan2(e, c) / s) * s;
        return {
            x: I + i * Math.cos(s),
            y: o + i * Math.sin(s),
            a: s
        }
    };
    svgedit.math.rectsIntersect = function(I, o) {
        return o.x < I.x + I.width && o.x + o.width > I.x && o.y < I.y + I.height && o.y + o.height > I.y
    }
})();
(function() {
    if (!svgedit.units) svgedit.units = {};
    var a = svgedit.NS,
        I = ["x", "x1", "cx", "rx", "width"],
        o = ["y", "y1", "cy", "ry", "height"],
        c = ["r", "radius"].concat(I, o),
        i, s = {};
    svgedit.units.init = function(g) {
        i = g;
        g = document.createElementNS(a.SVG, "svg");
        document.body.appendChild(g);
        var q = document.createElementNS(a.SVG, "rect");
        q.setAttribute("width", "1em");
        q.setAttribute("height", "1ex");
        q.setAttribute("x", "1in");
        g.appendChild(q);
        q = q.getBBox();
        document.body.removeChild(g);
        g = q.x;
        s = {
            em: q.width,
            ex: q.height,
            "in": g,
            cm: g /
                2.54,
            mm: g / 25.4,
            pt: g / 72,
            pc: g / 6,
            px: 1,
            "%": 0
        }
    };
    svgedit.units.getTypeMap = function() {
        return s
    };
    svgedit.units.shortFloat = function(g) {
        var q = i.getRoundDigits();
        if (!isNaN(g)) return +(+g).toFixed(q);
        if ($.isArray(g)) return svgedit.units.shortFloat(g[0]) + "," + svgedit.units.shortFloat(g[1]);
        return parseFloat(g).toFixed(q) - 0
    };
    svgedit.units.convertUnit = function(g, q) {
        q = q || i.getBaseUnit();
        return svgedit.units.shortFloat(g / s[q])
    };
    svgedit.units.setUnitAttr = function(g, q, w) {
        g.setAttribute(q, w)
    };
    var e = {
        line: ["x1", "x2", "y1",
            "y2"
        ],
        circle: ["cx", "cy", "r"],
        ellipse: ["cx", "cy", "rx", "ry"],
        foreignObject: ["x", "y", "width", "height"],
        rect: ["x", "y", "width", "height"],
        image: ["x", "y", "width", "height"],
        use: ["x", "y", "width", "height"],
        text: ["x", "y"]
    };
    svgedit.units.convertAttrs = function(g) {
        var q = g.tagName,
            w = i.getBaseUnit();
        if (q = e[q]) {
            var D = q.length,
                u;
            for (u = 0; u < D; u++) {
                var A = q[u],
                    p = g.getAttribute(A);
                if (p) isNaN(p) || g.setAttribute(A, p / s[w] + w)
            }
        }
    };
    svgedit.units.convertToNum = function(g, q) {
        if (!isNaN(q)) return q - 0;
        var w;
        if (q.substr(-1) === "%") {
            w =
                q.substr(0, q.length - 1) / 100;
            var D = i.getWidth(),
                u = i.getHeight();
            if (I.indexOf(g) >= 0) return w * D;
            if (o.indexOf(g) >= 0) return w * u;
            return w * Math.sqrt(D * D + u * u) / Math.sqrt(2)
        }
        D = q.substr(-2);
        w = q.substr(0, q.length - 2);
        return w * s[D]
    };
    svgedit.units.isValidUnit = function(g, q, w) {
        var D = false;
        if (c.indexOf(g) >= 0)
            if (isNaN(q)) {
                q = q.toLowerCase();
                $.each(s, function(p) {
                    if (!D)
                        if (RegExp("^-?[\\d\\.]+" + p + "$").test(q)) D = true
                })
            } else D = true;
        else if (g == "id") {
            g = false;
            try {
                var u = i.getElement(q);
                g = u == null || u === w
            } catch (A) {}
            return g
        }
        return D =
            true
    }
})();
(function() {
    function a(g) {
        if (svgedit.browser.supportsHVLineContainerBBox()) try {
            return g.getBBox()
        } catch (q) {}
        var w = $.data(g, "ref"),
            D = null,
            u;
        if (w) {
            u = $(w).children().clone().attr("visibility", "hidden");
            $(e).append(u);
            D = u.filter("line, path")
        } else D = $(g).find("line, path");
        var A = false;
        if (D.length) {
            D.each(function() {
                var p = this.getBBox();
                if (!p.width || !p.height) A = true
            });
            if (A) {
                g = w ? u : $(g).children();
                g = getStrokedBBox(g)
            } else g = g.getBBox()
        } else g = g.getBBox();
        w && u.remove();
        return g
    }
    if (!svgedit.utilities) svgedit.utilities = {};
    var I = svgedit.NS,
        o = "a,circle,ellipse,foreignObject,g,image,line,path,polygon,polyline,rect,svg,text,tspan,use".split(","),
        c = null,
        i = null,
        s = null,
        e = null;
    svgedit.utilities.init = function(g) {
        c = g;
        i = g.getDOMDocument();
        s = g.getDOMContainer();
        e = g.getSVGRoot()
    };
    svgedit.utilities.toXml = function(g) {
        return g.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/, "&#x27;")
    };
    svgedit.utilities.fromXml = function(g) {
        return $("<p/>").html(g).text()
    };
    svgedit.utilities.encode64 =
        function(g) {
            g = svgedit.utilities.encodeUTF8(g);
            if (window.btoa) return window.btoa(g);
            var q = Array(Math.floor((g.length + 2) / 3) * 4),
                w, D, u, A, p, v, t = 0,
                m = 0;
            do {
                w = g.charCodeAt(t++);
                D = g.charCodeAt(t++);
                u = g.charCodeAt(t++);
                A = w >> 2;
                w = (w & 3) << 4 | D >> 4;
                p = (D & 15) << 2 | u >> 6;
                v = u & 63;
                if (isNaN(D)) p = v = 64;
                else if (isNaN(u)) v = 64;
                q[m++] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".charAt(A);
                q[m++] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".charAt(w);
                q[m++] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".charAt(p);
                q[m++] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".charAt(v)
            } while (t < g.length);
            return q.join("")
        };
    svgedit.utilities.decode64 = function(g) {
        if (window.atob) return window.atob(g);
        var q = "",
            w, D, u = "",
            A, p = "",
            v = 0;
        g = g.replace(/[^A-Za-z0-9\+\/\=]/g, "");
        do {
            w = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".indexOf(g.charAt(v++));
            D = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".indexOf(g.charAt(v++));
            A = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".indexOf(g.charAt(v++));
            p = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".indexOf(g.charAt(v++));
            w = w << 2 | D >> 4;
            D = (D & 15) << 4 | A >> 2;
            u = (A & 3) << 6 | p;
            q += String.fromCharCode(w);
            if (A != 64) q += String.fromCharCode(D);
            if (p != 64) q += String.fromCharCode(u)
        } while (v < g.length);
        return unescape(q)
    };
    svgedit.utilities.encodeUTF8 = function(g) {
        if (g === null || typeof g === "undefined") return "";
        g = String(g);
        var q = "",
            w, D, u = 0;
        w = D = 0;
        u = g.length;
        var A;
        for (A = 0; A < u; A++) {
            var p = g.charCodeAt(A),
                v = null;
            if (p < 128) D++;
            else if (p > 127 && p < 2048) v = String.fromCharCode(p >>
                6 | 192, p & 63 | 128);
            else if ((p & 63488) != 55296) v = String.fromCharCode(p >> 12 | 224, p >> 6 & 63 | 128, p & 63 | 128);
            else {
                if ((p & 64512) != 55296) throw new RangeError("Unmatched trail surrogate at " + A);
                v = g.charCodeAt(++A);
                if ((v & 64512) != 56320) throw new RangeError("Unmatched lead surrogate at " + (A - 1));
                p = ((p & 1023) << 10) + (v & 1023) + 65536;
                v = String.fromCharCode(p >> 18 | 240, p >> 12 & 63 | 128, p >> 6 & 63 | 128, p & 63 | 128)
            }
            if (v !== null) {
                if (D > w) q += g.slice(w, D);
                q += v;
                w = D = A + 1
            }
        }
        if (D > w) q += g.slice(w, u);
        return q
    };
    svgedit.utilities.convertToXMLReferences = function(g) {
        var q,
            w = "";
        for (q = 0; q < g.length; q++) {
            var D = g.charCodeAt(q);
            if (D < 128) w += g[q];
            else if (D > 127) w += "&#" + D + ";"
        }
        return w
    };
    svgedit.utilities.text2xml = function(g) {
        if (g.indexOf("<svg:svg") >= 0) g = g.replace(/<(\/?)svg:/g, "<$1").replace("xmlns:svg", "xmlns");
        var q, w;
        try {
            w = window.DOMParser ? new DOMParser : new ActiveXObject("Microsoft.XMLDOM");
            w.async = false
        } catch (D) {
            throw Error("XML Parser could not be instantiated");
        }
        try {
            q = w.loadXML ? w.loadXML(g) ? w : false : w.parseFromString(g, "text/xml")
        } catch (u) {
            throw Error("Error parsing XML string");
        }
        return q
    };
    svgedit.utilities.bboxToObj = function(g) {
        return {
            x: g.x,
            y: g.y,
            width: g.width,
            height: g.height
        }
    };
    svgedit.utilities.walkTree = function(g, q) {
        if (g && g.nodeType == 1) {
            q(g);
            for (var w = g.childNodes.length; w--;) svgedit.utilities.walkTree(g.childNodes.item(w), q)
        }
    };
    svgedit.utilities.walkTreePost = function(g, q) {
        if (g && g.nodeType == 1) {
            for (var w = g.childNodes.length; w--;) svgedit.utilities.walkTree(g.childNodes.item(w), q);
            q(g)
        }
    };
    svgedit.utilities.getUrlFromAttr = function(g) {
        if (g) {
            if (g.indexOf('url("') === 0) return g.substring(5,
                g.indexOf('"', 6));
            if (g.indexOf("url('") === 0) return g.substring(5, g.indexOf("'", 6));
            if (g.indexOf("url(") === 0) return g.substring(4, g.indexOf(")"))
        }
        return null
    };
    svgedit.utilities.getHref = function(g) {
        return g.getAttributeNS(I.XLINK, "href")
    };
    svgedit.utilities.setHref = function(g, q) {
        g.setAttributeNS(I.XLINK, "xlink:href", q)
    };
    svgedit.utilities.findDefs = function() {
        var g = c.getSVGContent(),
            q = g.getElementsByTagNameNS(I.SVG, "defs");
        if (q.length > 0) q = q[0];
        else {
            q = g.ownerDocument.createElementNS(I.SVG, "defs");
            g.firstChild ?
                g.insertBefore(q, g.firstChild.nextSibling) : g.appendChild(q)
        }
        return q
    };
    svgedit.utilities.getPathBBox = function(g) {
        var q = g.pathSegList,
            w = q.numberOfItems;
        g = [
            [],
            []
        ];
        var D = q.getItem(0),
            u = [D.x, D.y];
        for (D = 0; D < w; D++) {
            var A = q.getItem(D);
            if (typeof A.x !== "undefined") {
                g[0].push(u[0]);
                g[1].push(u[1]);
                if (A.x1) {
                    var p = [A.x1, A.y1],
                        v = [A.x2, A.y2],
                        t = [A.x, A.y],
                        m;
                    for (m = 0; m < 2; m++) {
                        A = function(fa) {
                            return Math.pow(1 - fa, 3) * u[m] + 3 * Math.pow(1 - fa, 2) * fa * p[m] + 3 * (1 - fa) * Math.pow(fa, 2) * v[m] + Math.pow(fa, 3) * t[m]
                        };
                        var L = 6 * u[m] - 12 * p[m] +
                            6 * v[m],
                            R = -3 * u[m] + 9 * p[m] - 9 * v[m] + 3 * t[m],
                            da = 3 * p[m] - 3 * u[m];
                        if (R == 0) {
                            if (L != 0) {
                                L = -da / L;
                                0 < L && L < 1 && g[m].push(A(L))
                            }
                        } else {
                            da = Math.pow(L, 2) - 4 * da * R;
                            if (!(da < 0)) {
                                var qa = (-L + Math.sqrt(da)) / (2 * R);
                                0 < qa && qa < 1 && g[m].push(A(qa));
                                L = (-L - Math.sqrt(da)) / (2 * R);
                                0 < L && L < 1 && g[m].push(A(L))
                            }
                        }
                    }
                    u = t
                } else {
                    g[0].push(A.x);
                    g[1].push(A.y)
                }
            }
        }
        q = Math.min.apply(null, g[0]);
        w = Math.max.apply(null, g[0]) - q;
        D = Math.min.apply(null, g[1]);
        g = Math.max.apply(null, g[1]) - D;
        return {
            x: q,
            y: D,
            width: w,
            height: g
        }
    };
    svgedit.utilities.getBBox = function(g) {
        var q = g ||
            c.geSelectedElements()[0];
        if (g.nodeType != 1) return null;
        g = null;
        var w = q.nodeName;
        switch (w) {
            case "text":
                if (q.textContent === "") {
                    q.textContent = "a";
                    g = q.getBBox();
                    q.textContent = ""
                } else try {
                    g = q.getBBox()
                } catch (D) {}
                break;
            case "path":
                if (svgedit.browser.supportsPathBBox()) try {
                    g = q.getBBox()
                } catch (u) {} else g = svgedit.utilities.getPathBBox(q);
                break;
            case "g":
            case "a":
                g = a(q);
                break;
            default:
                if (w === "use") g = a(q, true);
                if (w === "use" || w === "foreignObject" && svgedit.browser.isWebkit()) {
                    g || (g = q.getBBox());
                    w = {};
                    w.width = g.width;
                    w.height = g.height;
                    w.x = g.x + parseFloat(q.getAttribute("x") || 0);
                    w.y = g.y + parseFloat(q.getAttribute("y") || 0);
                    g = w
                } else if (~o.indexOf(w)) try {
                    g = q.getBBox()
                } catch (A) {
                    q = $(q).closest("foreignObject");
                    if (q.length) try {
                        g = q[0].getBBox()
                    } catch (p) {
                        g = null
                    } else g = null
                }
        }
        if (g) g = svgedit.utilities.bboxToObj(g);
        return g
    };
    svgedit.utilities.getRotationAngle = function(g, q) {
        var w = g || c.getSelectedElements()[0];
        w = svgedit.transformlist.getTransformList(w);
        if (!w) return 0;
        var D = w.numberOfItems,
            u;
        for (u = 0; u < D; ++u) {
            var A = w.getItem(u);
            if (A.type == 4) return q ? A.angle * Math.PI / 180 : A.angle
        }
        return 0
    };
    svgedit.utilities.getRefElem = function(g) {
        return svgedit.utilities.getElem(svgedit.utilities.getUrlFromAttr(g).substr(1))
    };
    svgedit.utilities.getElem = svgedit.browser.supportsSelectors() ? function(g) {
        return e.querySelector("#" + g)
    } : svgedit.browser.supportsXpath() ? function(g) {
        return i.evaluate('svg:svg[@id="svgroot"]//svg:*[@id="' + g + '"]', s, function() {
            return svgedit.NS.SVG
        }, 9, null).singleNodeValue
    } : function(g) {
        return $(e).find("[id=" + g + "]")[0]
    };
    svgedit.utilities.assignAttributes = function(g, q, w, D) {
        w || (w = 0);
        svgedit.browser.isOpera() || e.suspendRedraw(w);
        for (var u in q)
            if (w = u.substr(0, 4) === "xml:" ? I.XML : u.substr(0, 6) === "xlink:" ? I.XLINK : null) g.setAttributeNS(w, u, q[u]);
            else D ? svgedit.units.setUnitAttr(g, u, q[u]) : g.setAttribute(u, q[u]);
        svgedit.browser.isOpera() || e.unsuspendRedraw(null)
    };
    svgedit.utilities.cleanupElement = function(g) {
        var q = e.suspendRedraw(60),
            w = {
                "fill-opacity": 1,
                "stop-opacity": 1,
                opacity: 1,
                stroke: "none",
                "stroke-dasharray": "none",
                "stroke-linejoin": "miter",
                "stroke-linecap": "butt",
                "stroke-opacity": 1,
                "stroke-width": 1,
                rx: 0,
                ry: 0
            },
            D;
        for (D in w) {
            var u = w[D];
            g.getAttribute(D) == u && g.removeAttribute(D)
        }
        e.unsuspendRedraw(q)
    };
    svgedit.utilities.snapToGrid = function(g) {
        var q = c.getSnappingStep(),
            w = c.getBaseUnit();
        if (w !== "px") q *= svgedit.units.getTypeMap()[w];
        return g = Math.round(g / q) * q
    };
    svgedit.utilities.preg_quote = function(g, q) {
        return String(g).replace(RegExp("[.\\\\+*?\\[\\^\\]$(){}=!<>|:\\" + (q || "") + "-]", "g"), "\\$&")
    }
})();
(function() {
    if (!svgedit.sanitize) svgedit.sanitize = {};
    var a = svgedit.NS,
        I = svgedit.getReverseNS(),
        o = {
            a: ["class", "clip-path", "clip-rule", "fill", "fill-opacity", "fill-rule", "filter", "id", "mask", "opacity", "stroke", "stroke-dasharray", "stroke-dashoffset", "stroke-linecap", "stroke-linejoin", "stroke-miterlimit", "stroke-opacity", "stroke-width", "style", "systemLanguage", "transform", "xlink:href", "xlink:title"],
            circle: ["class", "clip-path", "clip-rule", "cx", "cy", "fill", "fill-opacity", "fill-rule", "filter", "id", "mask",
                "opacity", "r", "requiredFeatures", "stroke", "stroke-dasharray", "stroke-dashoffset", "stroke-linecap", "stroke-linejoin", "stroke-miterlimit", "stroke-opacity", "stroke-width", "style", "systemLanguage", "transform"
            ],
            clipPath: ["class", "clipPathUnits", "id"],
            defs: [],
            style: ["type"],
            desc: [],
            ellipse: ["class", "clip-path", "clip-rule", "cx", "cy", "fill", "fill-opacity", "fill-rule", "filter", "id", "mask", "opacity", "requiredFeatures", "rx", "ry", "stroke", "stroke-dasharray", "stroke-dashoffset", "stroke-linecap", "stroke-linejoin",
                "stroke-miterlimit", "stroke-opacity", "stroke-width", "style", "systemLanguage", "transform"
            ],
            feGaussianBlur: ["class", "color-interpolation-filters", "id", "requiredFeatures", "stdDeviation"],
            filter: ["class", "color-interpolation-filters", "filterRes", "filterUnits", "height", "id", "primitiveUnits", "requiredFeatures", "width", "x", "xlink:href", "y"],
            foreignObject: ["class", "font-size", "letter-spacing", "height", "id", "opacity", "requiredFeatures", "style", "transform", "width", "x", "y"],
            g: ["class", "clip-path", "clip-rule", "id", "display",
                "fill", "fill-opacity", "fill-rule", "filter", "mask", "opacity", "requiredFeatures", "stroke", "stroke-dasharray", "stroke-dashoffset", "stroke-linecap", "stroke-linejoin", "stroke-miterlimit", "stroke-opacity", "stroke-width", "style", "systemLanguage", "transform", "font-family", "font-size", "letter-spacing", "font-style", "font-weight", "text-anchor"
            ],
            image: ["class", "clip-path", "clip-rule", "filter", "height", "id", "mask", "opacity", "requiredFeatures", "style", "systemLanguage", "transform", "width", "x", "xlink:href", "xlink:title", "y"],
            line: ["class",
                "clip-path", "clip-rule", "fill", "fill-opacity", "fill-rule", "filter", "id", "marker-end", "marker-mid", "marker-start", "mask", "opacity", "requiredFeatures", "stroke", "stroke-dasharray", "stroke-dashoffset", "stroke-linecap", "stroke-linejoin", "stroke-miterlimit", "stroke-opacity", "stroke-width", "style", "systemLanguage", "transform", "x1", "x2", "y1", "y2"
            ],
            linearGradient: ["class", "id", "gradientTransform", "gradientUnits", "requiredFeatures", "spreadMethod", "systemLanguage", "x1", "x2", "xlink:href", "y1", "y2"],
            marker: ["id",
                "class", "markerHeight", "markerUnits", "markerWidth", "orient", "preserveAspectRatio", "refX", "refY", "systemLanguage", "viewBox"
            ],
            mask: ["class", "height", "id", "maskContentUnits", "maskUnits", "width", "x", "y"],
            metadata: ["class", "id"],
            path: ["class", "clip-path", "clip-rule", "d", "fill", "fill-opacity", "fill-rule", "filter", "id", "marker-end", "marker-mid", "marker-start", "mask", "opacity", "requiredFeatures", "stroke", "stroke-dasharray", "stroke-dashoffset", "stroke-linecap", "stroke-linejoin", "stroke-miterlimit", "stroke-opacity",
                "stroke-width", "style", "systemLanguage", "transform"
            ],
            pattern: ["class", "height", "id", "patternContentUnits", "patternTransform", "patternUnits", "requiredFeatures", "style", "systemLanguage", "viewBox", "width", "x", "xlink:href", "y"],
            polygon: ["class", "clip-path", "clip-rule", "id", "fill", "fill-opacity", "fill-rule", "filter", "id", "class", "marker-end", "marker-mid", "marker-start", "mask", "opacity", "points", "requiredFeatures", "stroke", "stroke-dasharray", "stroke-dashoffset", "stroke-linecap", "stroke-linejoin", "stroke-miterlimit",
                "stroke-opacity", "stroke-width", "style", "systemLanguage", "transform"
            ],
            polyline: ["class", "clip-path", "clip-rule", "id", "fill", "fill-opacity", "fill-rule", "filter", "marker-end", "marker-mid", "marker-start", "mask", "opacity", "points", "requiredFeatures", "stroke", "stroke-dasharray", "stroke-dashoffset", "stroke-linecap", "stroke-linejoin", "stroke-miterlimit", "stroke-opacity", "stroke-width", "style", "systemLanguage", "transform"],
            radialGradient: ["class", "cx", "cy", "fx", "fy", "gradientTransform", "gradientUnits", "id",
                "r", "requiredFeatures", "spreadMethod", "systemLanguage", "xlink:href"
            ],
            rect: ["class", "clip-path", "clip-rule", "fill", "fill-opacity", "fill-rule", "filter", "height", "id", "mask", "opacity", "requiredFeatures", "rx", "ry", "stroke", "stroke-dasharray", "stroke-dashoffset", "stroke-linecap", "stroke-linejoin", "stroke-miterlimit", "stroke-opacity", "stroke-width", "style", "systemLanguage", "transform", "width", "x", "y"],
            stop: ["class", "id", "offset", "requiredFeatures", "stop-color", "stop-opacity", "style", "systemLanguage"],
            svg: ["class",
                "clip-path", "clip-rule", "filter", "id", "height", "mask", "preserveAspectRatio", "requiredFeatures", "style", "systemLanguage", "viewBox", "width", "x", "xmlns", "xmlns:se", "xmlns:xlink", "y"
            ],
            "switch": ["class", "id", "requiredFeatures", "systemLanguage"],
            symbol: ["class", "fill", "fill-opacity", "fill-rule", "filter", "font-family", "font-size", "letter-spacing",
             "font-style", "font-weight", "id", "opacity", "preserveAspectRatio", "requiredFeatures", "stroke", "stroke-dasharray", "stroke-dashoffset", "stroke-linecap", "stroke-linejoin", "stroke-miterlimit",
                "stroke-opacity", "stroke-width", "style", "systemLanguage", "transform", "viewBox"
            ],
            text: ["class", "clip-path", "clip-rule", "fill", "fill-opacity", "fill-rule", "filter", "font-family", "font-size","letter-spacing", "font-style", "font-weight", "id", "mask", "opacity", "requiredFeatures", "stroke", "stroke-dasharray", "stroke-dashoffset", "stroke-linecap", "stroke-linejoin", "stroke-miterlimit", "stroke-opacity", "stroke-width", "style", "systemLanguage", "text-anchor", "transform", "x", "xml:space", "y"],
            textPath: ["class", "id", "method", "requiredFeatures",
                "spacing", "startOffset", "style", "systemLanguage", "transform", "xlink:href"
            ],
            title: [],
            tspan: ["class", "clip-path", "clip-rule", "dx", "dy", "fill", "fill-opacity", "fill-rule", "filter", "font-family", "font-size","letter-spacing", "font-style", "font-weight", "id", "mask", "opacity", "requiredFeatures", "rotate", "stroke", "stroke-dasharray", "stroke-dashoffset", "stroke-linecap", "stroke-linejoin", "stroke-miterlimit", "stroke-opacity", "stroke-width", "style", "systemLanguage", "text-anchor", "textLength", "transform", "x", "xml:space", "y"],
            use: ["class",
                "clip-path", "clip-rule", "fill", "fill-opacity", "fill-rule", "filter", "height", "id", "mask", "stroke", "stroke-dasharray", "stroke-dashoffset", "stroke-linecap", "stroke-linejoin", "stroke-miterlimit", "stroke-opacity", "stroke-width", "style", "transform", "width", "x", "xlink:href", "y"
            ],
            annotation: ["encoding"],
            "annotation-xml": ["encoding"],
            maction: ["actiontype", "other", "selection"],
            math: ["class", "id", "display", "xmlns"],
            menclose: ["notation"],
            merror: [],
            mfrac: ["linethickness"],
            mi: ["mathvariant"],
            mmultiscripts: [],
            mn: [],
            mo: ["fence", "lspace", "maxsize", "minsize", "rspace", "stretchy"],
            mover: [],
            mpadded: ["lspace", "width", "height", "depth", "voffset"],
            mphantom: [],
            mprescripts: [],
            mroot: [],
            mrow: ["xlink:href", "xlink:type", "xmlns:xlink"],
            mspace: ["depth", "height", "width"],
            msqrt: [],
            mstyle: ["displaystyle", "mathbackground", "mathcolor", "mathvariant", "scriptlevel"],
            msub: [],
            msubsup: [],
            msup: [],
            mtable: ["align", "columnalign", "columnlines", "columnspacing", "displaystyle", "equalcolumns", "equalrows", "frame", "rowalign", "rowlines", "rowspacing",
                "width"
            ],
            mtd: ["columnalign", "columnspan", "rowalign", "rowspan"],
            mtext: [],
            mtr: ["columnalign", "rowalign"],
            munder: [],
            munderover: [],
            none: [],
            semantics: []
        },
        c = {};
    $.each(o, function(i, s) {
        var e = {};
        $.each(s, function(g, q) {
            if (q.indexOf(":") >= 0) {
                var w = q.split(":");
                e[w[1]] = a[w[0].toUpperCase()]
            } else e[q] = q == "xmlns" ? a.XMLNS : null
        });
        c[i] = e
    });
    svgedit.sanitize.sanitizeSvg = function(i) {
        if (i.nodeType == 3) {
            i.nodeValue = i.nodeValue.replace(/^\s+|\s+$/g, "");
            i.nodeValue.length === 0 && i.parentNode.removeChild(i)
        }
        if (i.nodeType == 1) {
            var s =
                i.parentNode;
            if (i.ownerDocument && s) {
                var e = o[i.nodeName],
                    g = c[i.nodeName],
                    q;
                if (typeof e !== "undefined") {
                    var w = [];
                    for (q = i.attributes.length; q--;) {
                        var D = i.attributes.item(q),
                            u = D.nodeName,
                            A = D.localName,
                            p = D.namespaceURI;
                        if (!(g.hasOwnProperty(A) && p == g[A] && p != a.XMLNS) && !(p == a.XMLNS && I[D.nodeValue])) {
                            u.indexOf("se:") === 0 && w.push([u, D.nodeValue]);
                            i.removeAttributeNS(p, A)
                        }
                        if (svgedit.browser.isGecko()) switch (u) {
                            case "transform":
                            case "gradientTransform":
                            case "patternTransform":
                                A = D.nodeValue.replace(/(\d)-/g, "$1 -");
                                i.setAttribute(u, A)
                        }
                        if (u == "style") {
                            D = D.nodeValue.split(";");
                            for (u = D.length; u--;) {
                                p = D[u].split(":");
                                A = $.trim(p[0]);
                                p = $.trim(p[1]);
                                e.indexOf(A) >= 0 && i.setAttribute(A, p)
                            }
                            i.removeAttribute("style")
                        }
                    }
                    $.each(w, function(v, t) {
                        i.setAttributeNS(a.SE, t[0], t[1])
                    });
                    if ((q = svgedit.utilities.getHref(i)) && ["filter", "linearGradient", "pattern", "radialGradient", "textPath", "use"].indexOf(i.nodeName) >= 0)
                        if (q[0] != "#") {
                            svgedit.utilities.setHref(i, "");
                            i.removeAttributeNS(a.XLINK, "href")
                        }
                    if (i.nodeName == "use" && !svgedit.utilities.getHref(i)) s.removeChild(i);
                    else {
                        $.each(["clip-path", "fill", "filter", "marker-end", "marker-mid", "marker-start", "mask", "stroke"], function(v, t) {
                            var m = i.getAttribute(t);
                            if (m)
                                if ((m = svgedit.utilities.getUrlFromAttr(m)) && m[0] !== "#") {
                                    i.setAttribute(t, "");
                                    i.removeAttribute(t)
                                }
                        });
                        for (q = i.childNodes.length; q--;) svgedit.sanitize.sanitizeSvg(i.childNodes.item(q))
                    }
                } else {
                    for (e = []; i.hasChildNodes();) e.push(s.insertBefore(i.firstChild, i));
                    s.removeChild(i);
                    for (q = e.length; q--;) svgedit.sanitize.sanitizeSvg(e[q])
                }
            }
        }
    }
})();
(function() {
    if (!svgedit.history) svgedit.history = {};
    svgedit.history.HistoryEventTypes = {
        BEFORE_APPLY: "before_apply",
        AFTER_APPLY: "after_apply",
        BEFORE_UNAPPLY: "before_unapply",
        AFTER_UNAPPLY: "after_unapply"
    };
    svgedit.history.MoveElementCommand = function(a, I, o, c) {
        this.elem = a;
        this.text = c ? "Move " + a.tagName + " to " + c : "Move " + a.tagName;
        this.oldNextSibling = I;
        this.oldParent = o;
        this.newNextSibling = a.nextSibling;
        this.newParent = a.parentNode
    };
    svgedit.history.MoveElementCommand.type = function() {
        return "svgedit.history.MoveElementCommand"
    };
    svgedit.history.MoveElementCommand.prototype.type = svgedit.history.MoveElementCommand.type;
    svgedit.history.MoveElementCommand.prototype.getText = function() {
        return this.text
    };
    svgedit.history.MoveElementCommand.prototype.apply = function(a) {
        a && a.handleHistoryEvent(svgedit.history.HistoryEventTypes.BEFORE_APPLY, this);
        this.elem = this.newParent.insertBefore(this.elem, this.newNextSibling);
        a && a.handleHistoryEvent(svgedit.history.HistoryEventTypes.AFTER_APPLY, this)
    };
    svgedit.history.MoveElementCommand.prototype.unapply =
        function(a) {
            a && a.handleHistoryEvent(svgedit.history.HistoryEventTypes.BEFORE_UNAPPLY, this);
            this.elem = this.oldParent.insertBefore(this.elem, this.oldNextSibling);
            a && a.handleHistoryEvent(svgedit.history.HistoryEventTypes.AFTER_UNAPPLY, this)
        };
    svgedit.history.MoveElementCommand.prototype.elements = function() {
        return [this.elem]
    };
    svgedit.history.InsertElementCommand = function(a, I) {
        this.elem = a;
        this.text = I || "Create " + a.tagName;
        this.parent = a.parentNode;
        this.nextSibling = this.elem.nextSibling
    };
    svgedit.history.InsertElementCommand.type =
        function() {
            return "svgedit.history.InsertElementCommand"
        };
    svgedit.history.InsertElementCommand.prototype.type = svgedit.history.InsertElementCommand.type;
    svgedit.history.InsertElementCommand.prototype.getText = function() {
        return this.text
    };
    svgedit.history.InsertElementCommand.prototype.apply = function(a) {
        a && a.handleHistoryEvent(svgedit.history.HistoryEventTypes.BEFORE_APPLY, this);
        this.elem = this.parent.insertBefore(this.elem, this.nextSibling);
        a && a.handleHistoryEvent(svgedit.history.HistoryEventTypes.AFTER_APPLY,
            this)
    };
    svgedit.history.InsertElementCommand.prototype.unapply = function(a) {
        a && a.handleHistoryEvent(svgedit.history.HistoryEventTypes.BEFORE_UNAPPLY, this);
        this.parent = this.elem.parentNode;
        this.elem = this.elem.parentNode.removeChild(this.elem);
        a && a.handleHistoryEvent(svgedit.history.HistoryEventTypes.AFTER_UNAPPLY, this)
    };
    svgedit.history.InsertElementCommand.prototype.elements = function() {
        return [this.elem]
    };
    svgedit.history.RemoveElementCommand = function(a, I, o, c) {
        this.elem = a;
        this.text = c || "Delete " + a.tagName;
        this.nextSibling = I;
        this.parent = o;
        svgedit.transformlist.removeElementFromListMap(a)
    };
    svgedit.history.RemoveElementCommand.type = function() {
        return "svgedit.history.RemoveElementCommand"
    };
    svgedit.history.RemoveElementCommand.prototype.type = svgedit.history.RemoveElementCommand.type;
    svgedit.history.RemoveElementCommand.prototype.getText = function() {
        return this.text
    };
    svgedit.history.RemoveElementCommand.prototype.apply = function(a) {
        a && a.handleHistoryEvent(svgedit.history.HistoryEventTypes.BEFORE_APPLY, this);
        svgedit.transformlist.removeElementFromListMap(this.elem);
        this.parent = this.elem.parentNode;
        this.elem = this.parent.removeChild(this.elem);
        a && a.handleHistoryEvent(svgedit.history.HistoryEventTypes.AFTER_APPLY, this)
    };
    svgedit.history.RemoveElementCommand.prototype.unapply = function(a) {
        a && a.handleHistoryEvent(svgedit.history.HistoryEventTypes.BEFORE_UNAPPLY, this);
        svgedit.transformlist.removeElementFromListMap(this.elem);
        this.nextSibling == null && window.console && console.log("Error: reference element was lost");
        this.parent.insertBefore(this.elem, this.nextSibling);
        a && a.handleHistoryEvent(svgedit.history.HistoryEventTypes.AFTER_UNAPPLY, this)
    };
    svgedit.history.RemoveElementCommand.prototype.elements = function() {
        return [this.elem]
    };
    svgedit.history.ChangeElementCommand = function(a, I, o) {
        this.elem = a;
        this.text = o ? "Change " + a.tagName + " " + o : "Change " + a.tagName;
        this.newValues = {};
        this.oldValues = I;
        for (var c in I) this.newValues[c] = c == "#text" ? a.textContent : c == "#href" ? svgedit.utilities.getHref(a) : a.getAttribute(c)
    };
    svgedit.history.ChangeElementCommand.type =
        function() {
            return "svgedit.history.ChangeElementCommand"
        };
    svgedit.history.ChangeElementCommand.prototype.type = svgedit.history.ChangeElementCommand.type;
    svgedit.history.ChangeElementCommand.prototype.getText = function() {
        return this.text
    };
    svgedit.history.ChangeElementCommand.prototype.apply = function(a) {
        a && a.handleHistoryEvent(svgedit.history.HistoryEventTypes.BEFORE_APPLY, this);
        var I = false,
            o;
        for (o in this.newValues) {
            if (this.newValues[o])
                if (o == "#text") this.elem.textContent = this.newValues[o];
                else o == "#href" ?
                    svgedit.utilities.setHref(this.elem, this.newValues[o]) : this.elem.setAttribute(o, this.newValues[o]);
            else if (o == "#text") this.elem.textContent = "";
            else {
                this.elem.setAttribute(o, "");
                this.elem.removeAttribute(o)
            }
            if (o == "transform") I = true
        }
        if (!I)
            if (I = svgedit.utilities.getRotationAngle(this.elem)) {
                o = elem.getBBox();
                I = ["rotate(", I, " ", o.x + o.width / 2, ",", o.y + o.height / 2, ")"].join("");
                I != elem.getAttribute("transform") && elem.setAttribute("transform", I)
            }
        a && a.handleHistoryEvent(svgedit.history.HistoryEventTypes.AFTER_APPLY,
            this);
        return true
    };
    svgedit.history.ChangeElementCommand.prototype.unapply = function(a) {
        a && a.handleHistoryEvent(svgedit.history.HistoryEventTypes.BEFORE_UNAPPLY, this);
        var I = false,
            o;
        for (o in this.oldValues) {
            if (this.oldValues[o])
                if (o == "#text") this.elem.textContent = this.oldValues[o];
                else o == "#href" ? svgedit.utilities.setHref(this.elem, this.oldValues[o]) : this.elem.setAttribute(o, this.oldValues[o]);
            else if (o == "#text") this.elem.textContent = "";
            else this.elem.removeAttribute(o);
            if (o == "transform") I = true
        }
        if (!I)
            if (I =
                svgedit.utilities.getRotationAngle(this.elem)) {
                o = elem.getBBox();
                I = ["rotate(", I, " ", o.x + o.width / 2, ",", 