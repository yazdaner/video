$(".bars").click(function () {
    $(".sidebar__nav").toggleClass("is-active");
    $(".content").toggleClass("is-active");
});
$(".notification__icon").on("click", function () {
    $(".dropdown__notification").toggleClass("is-active");
});
$(document).on("click", function (event) {
    if (
        !$(event.target).closest(".dropdown__notification").length &&
        !$(event.target).closest(".notification").length
    ) {
        $(".dropdown__notification").removeClass("is-active");
    }
});
$(".avatar-img__input").on("change", function () {
    var input = $(this);
    if (input[0] && input[0].files && input[0].files[0]) {
        if (!input[0].files[0].type.includes("image")) {
            // $('.avatar--img').attr('src', '../img/pr3o.png');
            return false;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".avatar___img").attr("src", e.target.result);
        };

        reader.readAsDataURL(input[0].files[0]);
    }
});
$("input:file").change(function (e) {
    // console.log(e.currentTarget.files);
    // var numFiles = e.currentTarget.files.length;
    var fileSize = parseInt(e.currentTarget.files[0].size, 10) / 1024;
    filesize = Math.round(fileSize);
    $(".filesize")
        .addClass("filesize")
        .text("(" + filesize + "kb)");
    $(".selectedFiles")
        .text(e.currentTarget.files[0].name)
        .appendTo($(".selectedFiles"));
});

function create_custom_dropdowns() {
    $("select").each(function (i, select) {
        if (!$(this).next().hasClass("dropdown-select")) {
            $(this).after(
                '<div class="dropdown-select wide ' +
                ($(this).attr("class") || "") +
                '" tabindex="0"><span class="current"></span><div class="list"><ul></ul></div></div>'
            );
            var dropdown = $(this).next();
            var options = $(select).find("option");
            var selected = $(this).find("option:selected");
            dropdown
                .find(".current")
                .html(selected.data("display-text") || selected.text());
            options.each(function (j, o) {
                var display = $(o).data("display-text") || "";
                dropdown
                    .find("ul")
                    .append(
                        '<li class="option ' +
                        ($(o).is(":selected") ? "selected" : "") +
                        '" data-value="' +
                        $(o).val() +
                        '" data-display-text="' +
                        display +
                        '">' +
                        $(o).text() +
                        "</li>"
                    );
            });
        }
    });

    $(".dropdown-select ul").before(
        '<div class="dd-search"><input id="txtSearchValue" autocomplete="off" onkeyup="filter()" class="dd-searchbox" type="text"></div>'
    );
}

$(document).on("click", ".dropdown-select", function (event) {
    if ($(event.target).hasClass("dd-searchbox")) {
        return;
    }
    $(".dropdown-select").not($(this)).removeClass("open");
    $(this).toggleClass("open");
    if ($(this).hasClass("open")) {
        $(this).find(".option").attr("tabindex", 0);
        $(this).find(".selected").focus();
    } else {
        $(this).find(".option").removeAttr("tabindex");
        $(this).focus();
    }
});

$(document).on("click", function (event) {
    if ($(event.target).closest(".dropdown-select").length === 0) {
        $(".dropdown-select").removeClass("open");
        $(".dropdown-select .option").removeAttr("tabindex");
    }
    event.stopPropagation();
});

function filter() {
    var valThis = $("#txtSearchValue").val();
    $(".dropdown-select ul > li").each(function () {
        var text = $(this).text();
        text.toLowerCase().indexOf(valThis.toLowerCase()) > -1
            ? $(this).show()
            : $(this).hide();
    });
}

$(document).on("click", ".dropdown-select .option", function (event) {
    $(this).closest(".list").find(".selected").removeClass("selected");
    $(this).addClass("selected");
    var text = $(this).data("display-text") || $(this).text();
    $(this).closest(".dropdown-select").find(".current").text(text);
    $(this)
        .closest(".dropdown-select")
        .prev("select")
        .val($(this).data("value"))
        .trigger("change");
});

$(document).on("keydown", ".dropdown-select", function (event) {
    var focused_option = $(
        $(this).find(".list .option:focus")[0] ||
        $(this).find(".list .option.selected")[0]
    );
    if (event.keyCode == 13) {
        if ($(this).hasClass("open")) {
            focused_option.trigger("click");
        } else {
            $(this).trigger("click");
        }
        return false;
        // Down
    } else if (event.keyCode == 40) {
        if (!$(this).hasClass("open")) {
            $(this).trigger("click");
        } else {
            focused_option.next().focus();
        }
        return false;
        // Up
    } else if (event.keyCode == 38) {
        if (!$(this).hasClass("open")) {
            $(this).trigger("click");
        } else {
            var focused_option = $(
                $(this).find(".list .option:focus")[0] ||
                $(this).find(".list .option.selected")[0]
            );
            focused_option.prev().focus();
        }
        return false;
        // Esc
    } else if (event.keyCode == 27) {
        if ($(this).hasClass("open")) {
            $(this).trigger("click");
        }
        return false;
    }
});

$(document).ready(function () {
    create_custom_dropdowns();
});

$(".checkedAll").on("click", function (e) {
    if ($(this).is(":checked", true)) {
        $(".sub-checkbox").prop("checked", true);
    } else {
        $(".sub-checkbox").prop("checked", false);
    }
});

$(document).on("click touchstart", function (e) {
    var serach__box = $(".t-header-search");
    var input = $(".search-input__box");
    if ($(e.target).is(serach__box) || serach__box.has(e.target).length == 1) {
        $(".t-header-search-content").show();
        $(".t-header-searchbox").addClass("open");
    } else {
        $(".t-header-search-content").hide();
        $(".t-header-searchbox").removeClass("open");
    }
});
$(".create-ads .ads-field-pn").on("click", function (e) {
    $(".file-upload").hide();
});
$(".create-ads .ads-field-banner").on("click", function (e) {
    $(".file-upload").show();
});

$('#discounts-field-2').on('click', function (e) {
    $('#selectCourseContainer').removeClass('d-none')
});
$('#discounts-field-1').on('click', function (e) {
    $('#selectCourseContainer').addClass('d-none')
});


function deleteItem(event, route, element = 'tr') {
    event.preventDefault();
    if (confirm("آیا از حذف این آیتم اطمینان دارید ؟")) {
        $.post(route, {
            _method: "delete",
            _token: $('meta[name="_token"]').attr('content'),
        })
            .done(function (response) {
                event.target.closest(element).remove();
                successMassage(response);
            })
            .fail(function (response) {
                errorMassage(response);
            });
    }
}

function UpdateConfirmationStatus(event, route, status, message, field = 'confirmation_status') {
    event.preventDefault();
    if (confirm(message)) {
        $.post(route, {
            _method: "patch",
            _token: $('meta[name="_token"]').attr('content'),
        })
            .done(function (response) {
                if (status == 'تایید شده') {
                    $(event.target).closest("tr").find('td.' + field).html("<span class='text-success'>" + status + "</span>");
                } else {
                    $(event.target).closest("tr").find('td.' + field).html("<span class='text-error'>" + status + "</span>");
                }
                successMassage(response);
            })
            .fail(function (response) {
                errorMassage(response);
            });
    }
}



function acceptAllLessons(route) {
    AllAction(route, 'patch', 'تایید شده', 'آیا مطمئن هستید که می خواهید این سطرها را تایید کنید؟');
}


function rejectAllLessons(route) {
    AllAction(route, 'patch', 'رد شده', 'آیا مطمئن هستید که می خواهید این سطرها را رد کنید؟');
}

function AllAction(route, method, status, message, field = 'confirmation_status') {
    if (confirm(message)) {
        $.ajax({
            type: method,
            url: route,
            cache: false,
            data: {
                _method: method,
                "_token": $('meta[name="_token"]').attr('content'),
            },
            success: function (response) {
                if (method == 'delete') {
                    $('table tr').remove();
                }
                if (method == 'patch') {
                    if (status == 'تایید شده') {
                        $('table tr').find('td.' + field).html("<span class='text-success'>" + status + "</span>");
                    } else {
                        $('table tr').find('td.' + field).html("<span class='text-error'>" + status + "</span>");
                    }
                }
                $(".sub-checkbox").prop("checked", false);
                $(".checkedAll").prop("checked", false);
                successMassage(response);
            },
            error: function (response) {
                errorMassage(response);
            }
        });
    }
}


function rejectMultiple(route) {
    multipleAction(route, 'patch', 'رد شده', 'آیا مطمئن هستید که می خواهید این سطرها را رد کنید؟');
}

function acceptMultiple(route) {
    multipleAction(route, 'patch', 'تایید شده', 'آیا مطمئن هستید که می خواهید این سطرها را تایید کنید؟');
}

function deleteMultiple(route) {
    multipleAction(route, 'delete', 'آیا مطمئن هستید که می خواهید این سطرها را حذف کنید؟');
}

function multipleAction(route, method, status, message, field = 'confirmation_status') {

    allValues = getSelectedItem()
    if (allValues.length <= 0) {
        alert("سطری انتخاب نشده است");
    } else {
        if (confirm(message)) {

            $.ajax({
                type: method,
                url: route,
                cache: false,
                data: {
                    _method: method,
                    "_token": $('meta[name="_token"]').attr('content'),
                    "ids": allValues
                },
                success: function (response) {
                    $.each(allValues, function (index, value) {
                        if (method == 'delete') {
                            $('table tr').filter("[data-row-id='" + value + "']").remove();
                        }
                        if (method == 'patch') {
                            if (status == 'تایید شده') {
                                $('table tr').filter("[data-row-id='" + value + "']").find('td.' + field).html("<span class='text-success'>" + status + "</span>");
                            } else {
                                $('table tr').filter("[data-row-id='" + value + "']").find('td.' + field).html("<span class='text-error'>" + status + "</span>");
                            }
                        }
                    });
                    $(".sub-checkbox").prop("checked", false);
                    $(".checkedAll").prop("checked", false);
                    successMassage(response);
                },
                error: function (response) {
                    errorMassage(response);
                }
            });
        }
    }
}

function getSelectedItem() {
    let allValues = [];
    $(".sub-checkbox:checked").each(function () {
        allValues.push($(this).attr('data-id'));
    });
    return allValues;
}

function errorMassage(response) {
    return $.toast({
        heading: "نا موفق",
        text: response.responseJSON.message,
        showHideTransition: "slide",
        icon: "error",
    });
}

function successMassage(response) {
    return $.toast({
        heading: "با موفقعیت",
        text: response.message,
        showHideTransition: "slide",
        icon: "success",
    });
}



function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
String.prototype.toEnglishDigits = function() {
    return this.replace(/[۰-۹]/g, function(chr) {
        var persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        return persian.indexOf(chr);
    });
};
