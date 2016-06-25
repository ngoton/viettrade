function preload_image(a) {
    var b = new Image;
    b.src = a
}

function OnloadExecute() {
    if (!window.onload_queue || window.onload_queue.length == 0) {
        return
    }
    for (var a = 0; a < window.onload_queue.length; a++) {
        window.onload_queue[a]()
    }
}

function Onload(a, c) {
    if (typeof(a) != "function") {
        return
    }
    if (!window.onload_queue_set) {
        window.onload_queue_set = true;
        var b = window.onload;
        window.onload = function() {
            if (typeof b != "undefined" && b != null) {
                b()
            }
            setTimeout(OnloadExecute, 10)
        }
    }
    if (!window.onload_queue) {
        window.onload_queue = []
    }
    if (c) {
        window.onload_queue.unshift(a)
    } else {
        window.onload_queue[window.onload_queue.length] = a
    }
}

function resize_eas_frame(a, e) {
    if (!document.org_domain) {
        document.org_domain = document.domain
    }
    var d = location.host;
    if (d.match(/^([0-9].){4}/)) {
        if (d.indexOf(":")) {
            d = d.substr(0, d.indexOf(":"))
        }
    } else {
        var b = d.split(".");
        if (b.length >= 2) {
            d = b[b.length - 2] + "." + b[b.length - 1]
        }
    }
    document.domain = d;
    var c = a.contentWindow ? a.contentWindow.document : a.contentDocument.document;
    a.height = c.body.scrollHeight;
    if (a.height == 0) {
        a.parentNode.removeChild(a)
    } else {
        if (c.body.scrollWidth < e) {
            a.width = c.body.scrollWidth
        } else {
            if (e) {
                a.width = e
            }
        }
    }
}

function clickcounter(a) {
    var b = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    b.open("GET", "/redir?nc=1&s=" + a, true);
    b.send(null)
}

function include_script(b, c) {
    var a = document.createElement("script");
    a.src = b;
    a.type = "text/javascript";
    if (c) {
        a.onload = c;
        a.onreadystatechange = function() {
            if (this.readyState == "complete" || this.readyState == "loaded") {
                this.onload();
                this.onload = this.onreadystatechange = null
            }
        }
    }
    document.getElementsByTagName("head")[0].appendChild(a)
}

function display_placeholder_tip() {
    var a = document.createElement("input");
    if ("placeholder" in a) {
        $("input.placeholder").each(function() {
            $(this).attr("placeholder", $(this).attr("title"))
        })
    } else {
        $("input.placeholder").each(function() {
            if ($(this).val() == "") {
                $(this).val($(this).attr("title"));
                $(this).addClass("input_idle");
                $(this).data("placeholder_set", true)
            }
            $(this).focus(function() {
                if ($(this).val() == $(this).attr("title")) {
                    $(this).val("");
                    $(this).unbind("click");
                    $(this).removeClass("input_idle");
                    $(this).data("placeholder_set", false)
                }
            });
            $(this).blur(function() {
                if ($(this).val() == "") {
                    $(this).val($(this).attr("title"));
                    $(this).addClass("input_idle");
                    $(this).data("placeholder_set", true)
                }
            })
        })
    }
}

function listen(d, c, b) {
    if (c.addEventListener) {
        c.addEventListener(d, b, false)
    } else {
        if (c.attachEvent) {
            var a = c.attachEvent("on" + d, b);
            return a
        }
    }
};;

function area_highlight() {
    var a = document.getElementsByTagName("area");
    var b = document.getElementById("area_highlight");
    var c = document.getElementById("region_list").getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
        a[i].onmouseover = function() {
            var d = this.id.substring(this.id.indexOf("_") + 1);
            var e = document.getElementById("region_" + d);
            b.className = "sprite_index_vn_hover_hover_region_" + d;
            e.style.color = "#6CC"
        };
        a[i].onmouseout = function() {
            var d = this.id.substring(this.id.indexOf("_") + 1);
            var e = document.getElementById("region_" + d);
            b.className = "";
            e.style.color = ""
        }
    }
    for (i = 0; i < c.length; i++) {
        c[i].onmouseover = function() {
            var d = this.id.substring(this.id.indexOf("_") + 1);
            b.className = "sprite_index_vn_hover_hover_region_" + d
        };
        c[i].onmouseout = function() {
            var d = this.id.substring(this.id.indexOf("_") + 1);
            b.className = ""
        }
    }
}
Onload(area_highlight);

function openiframe_support() {
    var a = document.getElementById("iframe_support");
    a.src = "/iframe_support.htm";
    var b = document.getElementById("box");
    b.style.display = "block";
    document.getElementById("shadowing").style.display = "block"
}

function startpage_ff() {
    document.getElementById("startpage_ff").style.display = "none";
    document.getElementById("startpage_ff_info").style.display = "block";
    startpage_set()
}

function startpage_cookie_get() {
    var a = document.cookie.split("; ");
    for (i = 0; i < a.length; i++) {
        if (a[i] == "b_sp=1") {
            return true
        }
    }
    return false
}

function startpage_set() {
    var a = new Date();
    a.setTime(a.getTime() + 1000 * 60 * 60 * 24 * 365);
    a = a.toUTCString();
    document.cookie = "b_sp=1; expires=" + a + ";";
    ajax_request("/redir?s=startpage_click&nc=1", null, startpage_callback, null, true, "GET");
    document.getElementById("startpage_ie").style.display = "none"
}

function startpage_callback(a, b, c) {}

function startpage_ff_info_close() {
    document.getElementById("startpage_ff_info").style.display = "none"
}

function startpage_set_default_ca(b, d, c) {
    setCookie("default_ca", b, 365, "/", d, false);
    var a = "";
    if (c) {
        a = "enter_from_map_region"
    } else {
        a = "enter_from_region_list"
    }
    xt_click(this, "C", xtn2, a, "N");
    return true
}

function setCookie(c, e, a, h, d, g) {
    var b = new Date();
    b.setTime(b.getTime());
    if (a) {
        a = a * 1000 * 60 * 60 * 24
    }
    var f = new Date(b.getTime() + (a));
    document.cookie = c + "=" + escape(e) + ((a) ? ";expires=" + f.toUTCString() : "") + ((h) ? ";path=" + h : "") + ((d) ? ";domain=" + d : "") + ((g) ? ";secure" : "")
}

function Pixel(b, j, l, h, g, m, f, c, e) {
    var a;
    var k = new Date();
    if (!j) {
        j = "failure_" + window.location.host.replace(/\.|:/gi, "_") + window.location.pathname.replace(/\/|\./g, "_")
    }
    a = b + "/1x1_pages_" + j;
    if (l) {
        a += "_c" + l
    } else {
        a += "_cpuk"
    }
    if (h) {
        a += "_a" + h
    } else {
        a += "_apuk"
    }
    if (g) {
        a += "_" + g
    }
    if (m) {
        a += "_" + m
    }
    if (f) {
        a += "_qh" + f
    }
    a = a + ".gif?r=" + k.getTime();
    if (c && getCookie(c)) {
        a += "&" + c + "=1"
    }
    if (document.write_org != null) {
        document.write_org('<img src="' + a + '" height="1" width="1" id="stats_1x1">')
    } else {
        document.write('<img src="' + a + '" height="1" width="1" id="stats_1x1">')
    }
}

function getCookie(c) {
    var d = document.cookie.indexOf(c + "=");
    var a = d + c.length + 1;
    if (!d && c != document.cookie.substring(0, c.length)) {
        return null
    }
    if (d == -1) {
        return null
    }
    var b = document.cookie.indexOf(";", a);
    if (b == -1) {
        b = document.cookie.length
    }
    return unescape(document.cookie.substring(a, b))
}

function include_script(b, c) {
    var a = document.createElement("script");
    a.src = b;
    a.type = "text/javascript";
    if (c) {
        a.onload = c;
        a.onreadystatechange = function() {
            if (this.readyState == "complete" || this.readyState == "loaded") {
                this.onload();
                this.onload = this.onreadystatechange = null
            }
        }
    }
    document.getElementsByTagName("head")[0].appendChild(a)
}

function facebook_online() {
    var a = new Image();
    a.src = "//www.facebook.com/images/spacer.gif?" + Math.random().toString(36).substring(7);
    a.id = "facebook_spacer";
    a.style.display = "none";
    a.style.width = "1px";
    a.style.height = "1px";
    document.getElementById("fb-root").appendChild(a);
    a.onload = function() {
        if (this.width == 1) {
            facebook_check(true)
        } else {
            facebook_check(false)
        }
    }
}

function facebook_init(e, a, f) {
    var c, b = e.getElementsByTagName(a)[0];
    if (e.getElementById(f)) {
        return
    }
    c = e.createElement(a);
    c.id = f;
    c.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1&appId=" + appId;
    b.parentNode.insertBefore(c, b)
}

function facebook_check(b) {
    if (b) {
        facebook_init(document, "script", "facebook-jssdk")
    } else {
        if (document.getElementsByClassName == undefined) {
            function a(l, m) {
                var e = [];
                var k = new RegExp("(^| )" + m + "( |$)");
                var h = l.getElementsByTagName("*");
                for (var g = 0, f = h.length; g < f; g++) {
                    if (k.test(h[g].className)) {
                        e.push(h[g])
                    }
                }
                return e
            }
            var d = a(document.body, "fb_like")
        } else {
            var d = document.getElementsByClassName("fb_like")
        }
        for (var c = 0; c < d.length; c++) {
            d[c].style.display = "none"
        }
    }
}
Onload(facebook_online);

function addSkyScraperBanner() {
    var d = new Image();
    d.src = static_url + "/img/BannerR.png";
    var a = document.getElementById("skyscraper_mm");
    a.appendChild(d);
    var b = new Image();
    b.src = static_url + "/img/BannerL.png";
    var c = document.getElementById("skyscraper_left_banner");
    c.appendChild(b)
};;
listen("load", window, setTVImage);

function setTVImage() {
    var a = document.getElementById("videobtn");
    var b = document.getElementById("youtube_description");
    if (a) {
        a.style.display = "block";
        a.style.background = 'url("/img/tv_gray.png") no-repeat scroll 17px 0 transparent'
    }
    if (b) {
        b.style.display = "block"
    }
}

function show_video_page() {
    var a = document.getElementById("video_box");
    a.style.display = "block";
    document.getElementById("gray_bg").style.display = "block";
    document.getElementById("video_frame").src = "youtube_lightbox_iframe.htm"
}

function close_video_box() {
    var a = document.getElementById("video_box");
    a.style.display = "none";
    document.getElementById("gray_bg").style.display = "none";
    document.getElementById("video_frame").src = ""
}

function setVideoActive(a) {
    a += 1;
    setCookie("video_active_id", a);
    video_active_id = a;
    show_video_page()
}

function getVideoActive() {
    return getCookie("video_active_id")
}
var btn_is_out = true;
var video_menu_is_out = true;
var youtube_arr = new Array("bYkSukzrybU", "qf4qEjdv0nY", "BE9smn_pOho");
var youtube_thumbnail_is_loaded = false;

function show_video_menu(b) {
    if (youtube_thumbnail_is_loaded == false) {
        for (var a = 0; a < youtube_arr.length; a++) {
            imgSrc = document.getElementById("youtube_thumbnail_" + a).getAttribute("src");
            if (imgSrc == "") {
                document.getElementById("youtube_thumbnail_" + a).src = "https://img.youtube.com/vi/" + youtube_arr[a] + "/3.jpg"
            }
        }
        youtube_thumbnail_is_loaded = true
    }
    if (b == 1) {
        btn_is_out = false
    } else {
        video_menu_is_out = false
    }
    document.getElementById("video_menu_container").style.display = "block"
}

function hide_video_menu(a) {
    if (a == 1) {
        btn_is_out = true
    } else {
        video_menu_is_out = true
    }
    if (btn_is_out == true && video_menu_is_out == true) {
        document.getElementById("video_menu_container").style.display = "none"
    }
}

function youtube_show_count_views(b, a, c) {
    yt_url = "https://gdata.youtube.com/feeds/api/videos/" + a + "?v=2&alt=json";
    $.ajax({
        url: yt_url,
        dataType: "jsonp",
        success: function(d) {
            viewcount = d.entry.yt$statistics.viewCount;
            $("#youtube_count_views_" + b).text(c + ": " + viewcount)
        },
        error: function(e, d) {}
    })
};;

function do_signin() {
    var username = $('#login_username').val();
    var password = $('#login_password').val();
    var persistent = $('#persistent').is(':checked') ? 1 : 0;
    var login_form_err = false;
    $('#err_login_message').text('');
    if (username == '') {
        login_form_err = true;
        $('#err_login_username').text(LOGIN_EMPTY_USERNAME).show();
    } else {
        $('#err_login_username').hide();
    }

    if (password == '') {
        login_form_err = true;
        $('#err_login_password').text(LOGIN_EMPTY_PASSWORD).show();
    } else {
        $('#err_login_password').hide();
    }

    if (login_form_err == false) {
        $('#bt_login').attr("disabled", true);
        data = {
            username: username,
            password: password,
            persistent: persistent
        };
        $.ajax({
            type: "POST",
            url: login_domain + '/do-signin',
            data: data,
            dataType: 'json',
            crossDomain: true,
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            },
            xhrFields: {
                withCredentials: true
            },
            success: function(response, status) {
                if (response['status'] == 'login_success') {
                    if (typeof response['url'] != 'undefined') {
                        window.location = response['url'];
                        return;
                    }
                    window.location = request_host + '/' + request_uri;
                } else {
                    if (typeof(response['msg']) != 'undefined') {
                        $('#err_login_message').text(response['msg']);
                    } else {
                        $('#err_login_message').text(LOGIN_FAILT);
                    }

                    if (response['status'] == 'login_fail_limit') {
                        $('#login_username').attr("disabled", true);
                        $('#login_password').attr("disabled", true);
                        $('#bt_login').attr("disabled", true);
                        $('.remember_me').hide()
                    } else {
                        $('#bt_login').attr("disabled", false);
                    }
                }
            }
        });
    }
    return;
}

function do_reg() {
    var fullname = $('#reg_fullname').val();
    var email = $('#reg_email').val();
    var phone = $('#reg_phone').val();
    var password = $('#reg_password').val();
    var password_confirm = $('#reg_password_confirm').val();
    var agreed = $('#reg_agreed').val();
    if (reg_pass_validate(fullname, email, phone, password, password_confirm, agreed)) {
        $('#bt_submit_register').attr("disabled", true);
        //var reg_domain = '<%$(common.base_url.reg)%>/reg';
        data = {
            fullname: fullname,
            email: email,
            phone: phone,
            password: password,
            password_confirm: password_confirm,
            agreed: agreed
        };
        $.ajax({
            type: "POST",
            url: reg_domain + '/do-reg',
            data: data,
            //contentType: "application/json; charset=utf-8",
            dataType: 'json',
            crossDomain: true,
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            },
            xhrFields: {
                withCredentials: true
            },
            success: function(response, status) {
                if (response['status'] == 'account_created') {
                    window.location = reg_domain + '/sms-verify/?sess=' + response['sess'] + '&phone=' + response['phone'];
                } else {
                    $('#bt_submit_register').prop("disabled", false);
                    if (response['error'] == 'EMAIL_EXISTED') {
                        $('#err_email').text(REG_EMAIL_EXISTED).show();
                    } else if (response['error'] == 'PASSWORD_INVALID_ERR') {
                        $('#err_password').text(PASSWORD_INVALID_ERR).show();
                    } else if (response['error'] == 'PHONE_EXISTED') {
                        $('#err_phone').text(REG_PHONE_EXISTED).show();
                    } else if (response['error'] == 'REGISTER_LIMIT_EXCEEDED') {
                        $('#reg_form .agreement_message').html(REGISTER_LIMIT_EXCEEDED).addClass('error').show();
                        $('#bt_submit_register, #reg_form input').prop('disabled', true);
                    }
                }
            }
        });
    }
    return false;
}

$("#reg_phone").on("keydown", function(e) {
    return e.which !== 32;
});

function reg_pass_validate(fullname, email, phone, password, confirm_password, agreed) {
    var err = false;
    if (phone == '') {
        err = true;
        $('#err_phone').text(REG_EMPTY_PHONE).show();
    } else if (!isPhone(phone)) {
        err = true;
        $('#err_phone').text(REG_INVALID_PHONE).show();
    } else {
        $('#err_phone').hide();
    }

    if (password == '') {
        err = true;
        $('#err_password').text(REG_EMPTY_PASSWORD).show();
    } else if (!isGoodPassword(password)) {
        err = true;
        $('#err_password').text(PASSWORD_INVALID_ERR).show();
    } else {
        $('#err_password').hide();
    }

    if (confirm_password == '') {
        err = true;
        $('#err_password_confirm').text(REG_EMPTY_PASSWORD_CONFIRM).show();
    } else if (confirm_password != password) {
        err = true;
        $('#err_password_confirm').text(REG_PASSWORD_CONFIRM_NOT_MATCH).show();
    } else {
        $('#err_password_confirm').hide();
    }

    return err == false;
}

function isEmail(email) {
    var emailReg = new RegExp(/^([\w-\.]+)@((?:[\w]+\.)+)([a-zA-Z]{2,4})/i);
    var valid = emailReg.test(email);
    if (!valid) {
        return false;
    } else {
        return true;
    }
}

function clearPopup() {
    $("#reg_modal, #login_form_container, .popup_container, #reg_form_container").hide();
}

function isPhone(phone) {
    var phoneReg = new RegExp(/^((\+84)|0)(9\d{2}|1\d{3})(\d{6})$/g);
    var valid = phoneReg.test(phone);
    if (!valid) {
        return false;
    } else {
        return true;
    }
}

function openRegisterForm() {
    clearPopup();
    $("#reg_form_container").show();
    $("#reg_modal").show();
    $("#reg_phone").focus();
}

function closeRegisterForm() {
    $("#reg_form_container").hide();
    $("#reg_modal").hide();
}

function openLoginForm() {
    clearPopup();
    $("#login_form_container").show();
    $("#reg_modal").show();
    $("#login_username").focus();
}

function closeLoginForm() {
    $("#login_form_container").hide();
    $("#reg_modal").hide();
}

function show_userinfo_box() {
    $("#userinfo_box").show();
}

function close_noti_cls() {
    $("#notification_msg").hide();
}
$(function() {
    $("#login_form").unbind('submit').submit(function() {
        do_signin();
        return false;
    });

    $("#reg_form").unbind('submit').submit(function() {
        do_reg();
        return false;
    });

    $('.close_popup_form').live('click', function() {
        $('.popup_container, #reg_modal').hide();
    });

    $("#reg_modal, #cancel_button").click(function() {
        $('.popup_container, #reg_modal').hide();
    });

})

function do_share(url, title) {
    var x = screen.width / 2 - 600 / 2;
    var y = screen.height / 2 - 400 / 2;
    window.open('http://www.facebook.com/share.php?u=' + url + '&t=' + title, 'share', 'height=400,width=600,left=' + x + ',top=' + y);
}

function openQuickFillInForm() {
    $("#QuickFillIn_form_container").show();
    $("#reg_modal").show();
    $('#QuickFillIn_username').focus();
}

function closeQuickFillInForm() {
    $("#QuickFillIn_form_container").hide();
    $("#reg_modal").hide();
    $("#QuickFillIn_username").val("");
    $("#QuickFillIn_passwd").val("");
    $('#err_QuickFillIn_message').text("");
}

function light_closeQuickFillInForm() {
    $("#QuickFillIn_form_container").hide();
    $("#QuickFillIn_username").val("");
    $("#QuickFillIn_passwd").val("");
    $('#err_QuickFillIn_message').text("");
}

function closeForgotPass() {
    $("#forgot_pass_container").hide();
    $("#reg_modal").hide();
}

function openForgotPass() {
    $.ajax({
        type: "GET",
        url: uac_domain + '/forgot-pass/phone-verify?source=newad',
        crossDomain: true,
        success: function(response, status) {
            if (!$('#forgot_pass_container').length)
                $("#QuickFillIn_form_container").before(response);
            else
                $("#forgot_pass_container").replaceWith(response);
            $('#forgot_pass_container').show();
            light_closeQuickFillInForm();
        }
    });
}

function openPreviewForgotPass(instance_id) {
    $.ajax({
        type: "GET",
        url: '/ai/send-otp/' + instance_id,
        success: function(response, status) {
            if (!$('#forgot_pass_container').length)
                $("#form_preview_table").before(response);
            else
                $("#forgot_pass_container").replaceWith(response);
            $('#forgot_pass_container').show();
            $("#reg_modal").show();
            light_closeQuickFillInForm();
        }
    });
}

function do_fgpass_sms_verified(source) {
    if ($('#fgpass_new_pass').val() == $('#confirm_pass').val() && $('#confirm_pass').val().length >= 5) {
        var phone = $('#fgpass_phone').val();
        var pass = $('#fgpass_new_pass').val();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: uac_domain + '/forgot-pass/sms-verified',
            data: {
                phone: phone,
                otp: $('#fgpass_otp').val(),
                token: $('#fgpass_token').val(),
                new_pass: pass
            },
            crossDomain: true,
            success: function(response, status) {
                if (response.status != 'PASS_UPDATED')
                    $('#err_fotgot_pass_sms').text(response.msg);
                else {
                    closeForgotPass();
                    $('#fgpass_msg').text(response.msg);
                    $('#fgpass_msg').show();
                    switch (source) {
                        case 'newad':
                            do_QuickFillIn(phone, pass);
                            break;
                        case 'preview':
                            $('#passwd_ver').val(pass);
                            $('#form_preview_table').hide();
                            break;
                        case 'register':
                            do_fgsignin(phone, pass);
                            break;
                    }
                }
            }
        });
    } else {
        if ($('#fgpass_new_pass').val() != $('#confirm_pass').val())
            $('#err_fotgot_pass_sms').text(PASS_NOT_MATCH);
        if ($('#confirm_pass').val().length < 5)
            $('#err_fotgot_pass_sms').text(PASS_LENGTH_NOT_ENOUGH);
    }
}

function isGoodPassword(pwd) {
    var pwdReg = new RegExp(/^.{5,40}$/);
    var valid = pwdReg.test(pwd);
    if (!valid) {
        return false;
    } else {
        return true;
    }
}

function openRegisterForgotPass() {
    clearPopup();
    $("#reg_modal").show();
    $.ajax({
        type: "GET",
        url: uac_domain + '/forgot-pass/phone-verify?source=register',
        crossDomain: true,
        success: function(response, status) {
            if (!$('#forgot_pass_container').length)
                $("#login_form_container").before(response);
            else
                $("#forgot_pass_container").replaceWith(response);
            $('#forgot_pass_container').show();
            $('#forgot_pass_phone').focus();
        }
    });
    return false;
}

function openHideAdForgotPass() {
    clearPopup();
    $("#reg_modal").show();
    if (typeof list_id != "undefined") {
        $.ajax({
            type: "GET",
            url: uac_domain + '/forgot-pass/phone-verify?source=hidead&list_id=' + list_id,
            crossDomain: true,
            success: function(response, status) {
                if (!$('#forgot_pass_container').length)
                    $("#login_form_container").before(response);
                else
                    $("#forgot_pass_container").replaceWith(response);
                $('#forgot_pass_container').show();
                $('#forgot_pass_phone').focus();
            }
        });
    }
    return false;
}

function openHideAd(t) {
    clearPopup();
    if (typeof t == 'undefined')
        var t = $('#hide_ad_btn');
    list_id = t.data('list-id');
    $.ajax({
        url: uac_domain + '/uac/do-get-hide-ad',
        crossDomain: true,
        data: {
            list_id: list_id
        },
        type: 'POST',
        dataType: 'json',
        xhrFields: {
            withCredentials: true
        },
        success: function(response, status) {
            if (response['success'] == 'false') {
                t.parent().find('.error_popover').text(response['error']);
                t.parent().find('.error_popover_wrapper').show();
                t.attr("disabled", "disabled").unbind('click').removeAttr('href');
                //disable auto show hide ad interval
                if (typeof disableDeleteButtond != 'undefined')
                    clearInterval(disableDeleteButtond);
            } else {
                $("#reg_modal").show();
                if (!$('#hide_ad_form_container').length)
                    $("#login_form_container").before(response['html']);
                else
                    $("#hide_ad_form_container").replaceWith(response['html']);
                $('#hide_ad_form_container').show();
            }
        }
    });
    return false;
}

function openSendOtp(source) {
    clearPopup();
    var data = {};

    if (typeof source != "undefined") {
        data['source'] = source;
    }
    $.ajax({
        url: uac_domain + '/uac/do-get-resend-otp',
        crossDomain: true,
        type: 'POST',
        data: data,
        dataType: 'json',
        xhrFields: {
            withCredentials: true
        },
        success: function(response, status) {
            console.debug(response);
            if (response['success'] == 'true') {
                $("#reg_modal").show();
                if (!$('#resend_otp_form_container').length)
                    $("#login_form_container").before(response['html']);
                else
                    $("#resend_otp_form_container").replaceWith(response['html']);
                $('#resend_otp_form_container').show();
            }
        }
    });
    return false;
}

;