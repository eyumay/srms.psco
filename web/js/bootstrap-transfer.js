

$(document).ready(function() {
    /*$("#student_info_college_id").val(1).attr("selected", "selected");
     $("#student_info_department_id").val(1).attr("selected", "selected");
     $("#student_info_program_id").val(1).attr("selected", "selected");
     
     if (programid != -1){
     $("#student_info_college_id").val(1).attr("selected", "selected");
     $("#student_info_department_id").val(departemntid).attr("selected", "selected");
     $("#student_info_program_id").val(programid).attr("selected", "selected");
     }
     $("#student_info_year").val(2).attr("selected", "selected");
     
     if (yr != -1){
     $("#student_info_year").val(2).attr("selected", "selected");
     $("#student_info_semester").val(sm).attr("selected", "selected");
     }
     
     */
});

$(document).ready(function() {
    /*mycars[0] = "Taye Shitaw Alaminew";
     mycars[2] = "Zelalem Mekonen Dagnaw";
     mycars[4] = "Wubet Shitew Alaminew";
     mycars[111] = "Betselot Hailu Abebe";
     mycars[21] = "Asmamaw Lashitew Mekuriaw";*/
    //mycars[77]=th;
    //mycars[77]=studlist[1];
    /*mycars=studlist;*/
    /* for (var i in studlist) {
     mycars[i]=studlist[i];
     }*/
    // $("#student_info_year").val('5').attr("selected", "selected");
});

var valuesel;
$(function() {
    var t = $('#test').bootstrapTransfer(
            {'target_id': 'multi-select-input',
                'height': '30em',
                'hilite_selection': true});

    valuesel = t;

    t.populate(

            );


    t.set_values(promstud);
//t.set_values(["2", "4"]); 
//t.set_values(["1", "3"]); 
    //t.set_values(["2", "4"]);
    //console.log(t.get_values());
    //if (error[0] != "")

});



$(document).ready(function() {
});







(function($) {





    $.fn.bootstrapTransfer = function(options) {
        var settings = $.extend({}, $.fn.bootstrapTransfer.defaults, options);
        var _this;
        /* #=============================================================================== */
        /* # Expose pselvalueublic functions */
        /* #=============================================================================== */
        this.populate = function(input) {
            _this.populate(input);
        };
        this.selvalue = function() {
            _this.getSelElem();
        };

        this.set_values = function(values) {
            _this.set_values(values);
        };
        this.get_values = function() {
            return _this.get_values();
        };
        return this.each(function() {
            _this = $(this);
            /* #=============================================================================== */
            /* # Add widget markup */
            /* #=============================================================================== */
            _this.append($.fn.bootstrapTransfer.defaults.template);
            _this.addClass("bootstrap-transfer-container");
            /* #=============================================================================== */
            /* # Initialize internal variables */
            /* #=============================================================================== */
            _this.$filter_input = _this.find('.filter-input');
            _this.$remaining_select = _this.find('select.remaining');
            _this.$target_select = _this.find('select.target');
            _this.$add_btn = _this.find('.selector-add');
            _this.$remove_btn = _this.find('.selector-remove');
            _this.$choose_all_btn = _this.find('.selector-chooseall');
            _this.$clear_all_btn = _this.find('.selector-clearall');
            _this._remaining_list = [];
            _this._target_list = [];
            /* #=============================================================================== */
            /* # Apply settings */
            /* #=============================================================================== */
            /* target_id */
            if (settings.target_id != '')
                _this.$target_select.attr('id', settings.target_id);
            /* height */
            _this.find('select.filtered').css('height', settings.height);
            /* #=============================================================================== */
            /* # Wire internal events */
            /* #=============================================================================== */
            _this.$add_btn.click(function() {
                _this.move_elems(_this.$remaining_select.val(), false, true);
            });
            _this.$remove_btn.click(function() {
                _this.move_elems(_this.$target_select.val(), true, false);
            });
            _this.$choose_all_btn.click(function() {
                _this.move_all(false, true);
            });
            _this.$clear_all_btn.click(function() {
                _this.move_all(true, false);
            });
            _this.$filter_input.keyup(function() {
                _this.update_lists(true);
            })
            ///////////////////////////////////////////////////////////////////////
            _this.getSelElem = function() {
                return _this.$remaining_select.val();
            }
            /////////////////////////////////////////////////////////////////////////////
            /* #=============================================================================== */
            /* # Implement public functions */
            /* #=============================================================================== */
            //_this._remaining_list.push([{value:10, content:"Asmamaw Lashitew"}, true]);

            _this.populate2 = function() {
                // input: [{value:_, content:_}]
                for (var i in studlist) {
                    _this._remaining_list.push([{value: i, content: studlist[i]}, true]);
                    _this._target_list.push([{value: i, content: studlist[i]}, false]);
                }
                _this.update_lists(true);
            };
            _this.populate = function(input) {
                // input: [{value:_, content:_}]
                _this.$filter_input.val('');
                for (var i in input) {
                    var e = input[i];
                    _this._remaining_list.push([{value: e.value, content: e.content}, true]);
                    _this._target_list.push([{value: e.value, content: e.content}, false]);
                }
                for (var i in studlist) {
                    _this._remaining_list.push([{value: i, content: studlist[i]}, true]);
                    _this._target_list.push([{value: i, content: studlist[i]}, false]);
                }
                _this.update_lists(true);
            };
            _this.set_values = function(values) {
                _this.move_elems(values, false, true);
            };
            _this.get_values = function() {
                return _this.get_internal(_this.$target_select);
            };
            /* #=============================================================================== */
            /* # Implement private functions */
            /* #=============================================================================== */
            _this.get_internal = function(selector) {
                var res = [];
                selector.find('option').each(function() {
                    res.push($(this).val());
                })
                return res;
            };
            _this.to_dict = function(list) {
                var res = {};
                for (var i in list)
                    res[list[i]] = true;
                return res;
            }
            _this.update_lists = function(force_hilite_off) {
                var old;
                if (!force_hilite_off) {
                    old = [_this.to_dict(_this.get_internal(_this.$remaining_select)),
                        _this.to_dict(_this.get_internal(_this.$target_select))];
                }
                _this.$remaining_select.empty();
                _this.$target_select.empty();
                var lists = [_this._remaining_list, _this._target_list];
                var source = [_this.$remaining_select, _this.$target_select];
                for (var i in lists) {
                    for (var j in lists[i]) {
                        var e = lists[i][j];
                        if (e[1]) {
                            var selected = '';
                            if (!force_hilite_off && settings.hilite_selection && !old[i].hasOwnProperty(e[0].value)) {
                                selected = 'selected="selected"';
                            }
                            source[i].append('<option ' + selected + 'value=' + e[0].value + '>' + e[0].content + '</option>');
                        }
                    }
                }
                _this.$remaining_select.find('option').each(function() {
                    var inner = _this.$filter_input.val().toLowerCase();
                    var outer = $(this).html().toLowerCase();
                    if (outer.indexOf(inner) == -1) {
                        $(this).remove();
                    }
                })
            };
            _this.move_elems = function(values, b1, b2) {
                for (var i in values) {
                    val = values[i];
                    for (var j in _this._remaining_list) {
                        var e = _this._remaining_list[j];
                        if (e[0].value == val) {
                            e[1] = b1;
                            _this._target_list[j][1] = b2;
                        }
                    }
                }
                _this.update_lists(false);
            };
            _this.move_all = function(b1, b2) {
                for (var i in _this._remaining_list) {
                    _this._remaining_list[i][1] = b1;
                    _this._target_list[i][1] = b2;
                }
                _this.update_lists(false);
            };
            _this.data('bootstrapTransfer', _this);


            $('#ttest').click(function() {

                alert(_this.$remaining_select.val());
            });


            var option = {width: 150, items: [
                    {text: "View Grade", icon: "/images/asm/menu/detail.png", alias: "1-1", type: "group", width: 180, items: [
                            {text: "Current Semester", icon: "/images/asm/menu/detail.png", alias: "2-1", action: mymenuaction},
                            {text: "All Semesters", icon: "/images/asm/menu/detail.png", alias: "2-2", action: menuAction}
                        ]
                    },
                    {text: "Show NG", icon: "/images/asm/menu/detail.png", alias: "1-3", type: "group", width: 180, items: [
                            {text: "Selected Student", icon: "/images/asm/menu/detail.png", alias: "2-5", action: menuAction},
                            {text: "All Student", icon: "/images/asm/menu/detail.png", alias: "2-6", action: menuAction}
                        ]
                    },
                    {text: "Show Exam Result ", icon: "/images/asm/menu/detail.png", alias: "1-4", action: menuAction},
                    {type: "splitLine"},
                    {text: "Show Setting", icon: "/images/asm/menu/detail.png", alias: "1-2", type: "group", width: 180, items: [
                            {text: "Grade Setting", icon: "/images/asm/menu/detail.png", alias: "2-3", action: menuAction},
                            {text: "Promotion Setting", icon: "/images/asm/menu/detail.png", alias: "2-4", action: menuAction}
                        ]
                    },
                ], onShow: applyrule,
                onContextMenu: BeforeContextMenu
            };
            function menuAction() {
                alert(this.data.alias);
            }
            function mymenuaction() {
                $('#promotform').attr('action', '/frontend_dev.php/promotion/viewStudDetail?stid=' + _this.$remaining_select.val() + '&' + 'stid2=' + $('#student_info_student_id').val());
                $('#promotform').submit();
                // alert(_this.$remaining_select.val());
            }
            function applyrule(menu) {
                if (this.id == "target2") {
                    menu.applyrule({name: "target2",
                        disable: true,
                        items: ["1-2", "2-3", "2-4", "1-6"]
                    });
                }
                else {
                    menu.applyrule({name: "all",
                        disable: true,
                        items: []
                    });
                }
            }
            function BeforeContextMenu() {
                return this.id != "target3";
            }
            $("#custom,#target,#target2,#target3").contextmenu(option);








            return _this;

        });
    };
    $.fn.bootstrapTransfer.defaults = {
        'template':
                '<table width="100%" cellspacing="0" cellpadding="0">\
                <tr>\
                    <td width="50%">\
                        <div class="selector-available">\
                            <h2>Available</h2>\
                            <div class="selector-filter">\
                                <table width="100%" border="0">\
                                    <tr>\
                                        <td style="width:14px;">\
                                            <i class="icon-search"></i>\
                                        </td>\
                                        <td>\
                                            <div style="padding-left:10px;">\
                                                <input type="text" class="filter-input">\
                                            </div>\
                                        </td>\
                                    </tr>\
                                </table>\
                            </div>\
                            <select multiple="multiple" class="filtered remaining" id="custom">\
                            </select>\
                            <a href="#" class="selector-chooseall">Choose all</a>\
                        </div>\
                    </td>\
                    <td>\
                        <div class="selector-chooser">\
                            <a href="#" class="selector-add">add</a>\
                            <a href="#" class="selector-remove">rem</a>\
                        </div>\
                    </td>\
                    <td width="50%">\
                        <div class="selector-chosen">\
                            <h2>Promoted</h2>\
                            <div class="selector-filter right">\
                                <p>List of Promoted Students</p><span></span>\
                            </div>\
                            <select multiple="multiple" class="filtered target" name="custom_name[]">\
                            </select>\
                            <a href="#" class="selector-clearall">Clear all</a>\
                        </div>\
                    </td>\
                </tr>\
            </table>',
        'height': '10em',
        'hilite_selection': true,
        'target_id': ''
    }



})(jQuery);
$(document).ready(function() {
    $('#promot').click(function() {
        /*var app = true;
         $.each(approv, function(name, value) {
         if (value != 'approved') {
         alert(name + ' is not approved\n');
         app = false;
         
         }
         });*/
        //if (app == true) {
        $('#promotform').attr('action', '/frontend_dev.php/promotion/promotStud');
        $('#promotform').submit();

        // }
    });
});