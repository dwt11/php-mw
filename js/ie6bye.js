(function() {
    function e(e) {
        var t = document.getElementsByTagName("script"),
        r;
        
        var i, s = /(?:\?|&)(.+?)=(.*?)(?=\?|&|$)/g,
        o = r.substr(r.indexOf("?"));
        while (i = s.exec(o)) if (i[1].toLowerCase() == e.toLowerCase()) try {
            return decodeURIComponent(i[2])
        } catch(u) {
            return i[2]
        }
    }
    function t(e) {
        return document.getElementById(e)
    }
    function n(e, t) {
        var n = 0,
        r = e.length;
        for (var i = e[0]; n < r && t.call(i, n, i) !== !1; i = e[++n]);
    }
    function s() {
        var e = !1;
        ua = navigator.userAgent.toLowerCase(),
        ua.indexOf("chrome") > -1 && (e = ua.indexOf("qqbrowser") > -1 || ua.indexOf(" se ") > -1 || ua.indexOf("360ee") == -1 ? !1 : !0);
        try {
            if (window.external && window.external.twGetRunPath) {
                var t = external.twGetRunPath();
                t && t.toLowerCase().indexOf("360se") > -1 && (e = !0)
            }
        } catch(n) {
            e = !1
        }
        return e
    }
    function o(e) {
        var t = document.createElement("style");
        document.getElementsByTagName("head")[0].appendChild(t),
        t.styleSheet.cssText = e
    }
    function u(e, t, n) {
        n = n || 1;
        var r = new Date;
        r.setTime(r.getTime() + n * 24 * 60 * 60 * 1e3),
        document.cookie = e + "=" + escape(t) + ";expires=" + r.toGMTString()
    }
    function a(e) {
        var t = document.cookie.match(new RegExp("(^| )" + e + "=([^;]*)(;|$)"));
        return t != null ? unescape(t[2]) : null
    }
    function f(e, t) {
        var n = arguments.callee;
        "queue" in n || (n.queue = {});
        var r = n.queue;
        if (e in r) {
            t && (r[e] ? r[e].push(t) : t());
            return
        }
        r[e] = t ? [t] : [];
        var i = document.createElement("script");
        i.type = "text/javascript",
        i.onload = i.onreadystatechange = function() {
            if (i.readyState && i.readyState != "loaded" && i.readyState != "complete") return;
            i.onreadystatechange = i.onload = null;
            while (r[e].length) r[e].shift()();
            r[e] = null
        },
        i.src = e,
        document.getElementsByTagName("head")[0].appendChild(i)
    }
    if (navigator.platform.toLowerCase().indexOf("win") != 0) return;
    var l = "/images/ie6bye_0322.jpg",
    c = ' style="font-family:SimSun; background:#F8EFB4; filter:alpha(opacity=90);  border-bottom:1px solid #EED64D; color:#503708; height:42px; line-height:42px; padding-top:7px; text-align:center; width:100%; font-size:12px; "',
    h = ' style="width:990px; margin: 0 auto;"',
    p = "background:url(" + l + ");display:inline-block;height:32px;vertical-align:middle;margin:0 5px 2px;",
    d = ' style="' + p + 'width:17px;height:17px;background-position:-112px -65px;cursor:pointer; "',
    v = ' style="' + p + 'width:50px;background-position:-152px 0;"',
    m = ' style="' + p + 'width:110px;background-position:0 -33px;"',
    g = ' style="' + p + 'width:112px;background-position:-40px 0;"',
    y = ' style="' + p + 'width:112px;background-position:0 -65px;"',
    b = ' style="' + p + 'width:40px;height:33px;"',
    w = "color:#2078D2; text-decoration:none;",
    E = ' style="font-weight:bold; color:#353C8F;text-decoration:none;"',
    S = ' style=" color:rgb(82,52,8);text-decoration:none;margin-left:20px;"',
	alertstr1="<div" + c + ' class="ie6fixedTL" id="qihoo_ie6_tips"><div' + h + "><em" + b + '></em>\u60a8\u7684\u6d4f\u89c8\u5668<b>\u7248\u672c\u592a\u4f4e</b>\uff0c\u8bf7\u5207\u6362\u4e3a<b>\u6781\u901f(\u9ad8\u901f)\u6a21\u5f0f</b>\uff0c\u6216\u4e0b\u8f7d<a href="http://se.360.cn/" bk="ie6_se" id="qihoo_ie6_tips_se" ' + m + ' target="_blank"></a><a href="#" bk="ie6_notip" id="qihoo_ie6_tips_close" ' + S + "><b>\u5173\u95ed</b></a></div></div>";
	alertstr2="<div" + c + ' class="ie6fixedTL" id="qihoo_ie6_tips"><div' + h + "><em" + b + '></em>\u60a8\u7684\u6d4f\u89c8\u5668<b>\u7248\u672c\u592a\u4f4e</b>\uff0c\u8bf7\u5207\u6362\u4e3a<b>\u6781\u901f(\u9ad8\u901f)\u6a21\u5f0f</b>\uff0c\u6216\u4e0b\u8f7d<a href="http://se.360.cn/" bk="ie6_se" id="qihoo_ie6_tips_se" ' + m + ' target="_blank"></a><a href="#" bk="ie6_notip" id="qihoo_ie6_tips_close" ' + S + "><b>\u5173\u95ed</b></a></div></div>";
	
    if (/MSIE 10/i.test(navigator.userAgent) && !/MSIE [^10]/i.test(navigator.userAgent)) return;
    var x = location.hostname,
    T = /MSIE 6/i.test(navigator.userAgent) && !/MSIE [^6]/i.test(navigator.userAgent) || /MSIE 7/i.test(navigator.userAgent) && !/MSIE [^7]/i.test(navigator.userAgent) || /MSIE 8/i.test(navigator.userAgent) && !/MSIE [^8]/i.test(navigator.userAgent);
    if (T) {
        window.onerror = function() {
            return ! 0
        },
        "none" == document.body.currentStyle.backgroundImage && o("* html,* html body{background-image:url(about:blank);background-attachment:fixed}"),
        o("* html .ie6fixedTL{position:absolute;z-index:2147483647;left:0;top:expression(eval(document.documentElement.scrollTop))};* html body{margin:0}"),
        s() ? document.body.insertAdjacentHTML("afterBegin", alertstr1) : document.body.insertAdjacentHTML("afterBegin", alertstr2);
        if (t("qihoo_ie6_tips")) {
            t("qihoo_ie6_tips_close").onclick = function() {
                t("qihoo_ie6_tips").style.display = "none",
                document.body
            },
            t("qihoo_ie6_tips_se").onmouseup = function() {
                i(x + "_se")
            };
            function N() { (document.documentElement.clientWidth || document.body.clientWidth) < 1035 ? t("qihoo_ie6_tips").style.width = "1035px": t("qihoo_ie6_tips").style.width = "100%"
            }
            N(),
            window.attachEvent("onresize", N),
            r(x)
        }
       
    }
})();