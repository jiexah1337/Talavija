//Overrides the edit buttons where needed
function editButtonOverride(classOverride, targetOverride){
    if(classOverride == null){
        classOverride = ".edit-btn";
    }

    if(targetOverride == null){
        targetOverride = '#modalContainer';
    }

    $(classOverride).each(function(index){
        $(this).unbind("click");
        $(this).on("click", function(e){
            e.preventDefault();
            type = $(this).data("editable-type");
            id = $(this).data("editable");
            url = "/"+type+"/"+"edit"+"/"+id;
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data){
                    $(targetOverride).html(data.html);
                }
            });
        });
    });
};

function repatriationEditButtons(){
    $(".rep-edit").each(function(index){
        $(this).unbind("click");
        $(this).on("click", function(e){
            e.preventDefault();
            year =      $(this).data("year");
            month =     $(this).data("month");
            member =    $(this).data("member");

            url = "/money/edit/" + member + "/" + year + "/" + month;
            window.open(url);
            // $.ajax({
            //     type: 'GET',
            //     url: url,
            //     success: function(data){
            //         $('#modalContainer').html(data.html);
            //     }
            // })

        })
    })
}

//Overrides the delete buttons where needed
function deleteButtonOverride(ignoreModal){
    $(".delete-btn").each(function(index){
        $(this).unbind("click");
        $(this).on("click", function(e){
            e.preventDefault();
            type = $(this).data("editable-type");
            id = $(this).data("editable");
            url = "/"+type+"/"+"delete"+"/"+id;
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data){

                    if(ignoreModal == false || ignoreModal == null){
                        $('#modalContainer').html(data.html);
                    }

                    if(data.loaderTrgt != null){
                        dataLoader($(data.loaderTrgt), data.loaderLink)
                    }
                },
                error: function (data) {
                    alert(data.html);
                }
            });
        })
    })
}

function tooltipInit(){
    $('[data-toggle="tooltip"]').tooltip();
}

$(document).ready(function(){
    //TWBS Tooltip initializer
    tooltipInit();
    mapLinkLoader();
});

//Function that is used by bio page to load data into their respective columns
function dataLoader(element, url){
    $.ajax({
        type: 'GET',
        url: url,
        success: function(data){
            element.html(data.html);
            editButtonOverride();
            deleteButtonOverride();
            mapLinkLoader();
        }
    })
}

function mapLinkLoader(){
    $(".map-btn").each(function(index){
        $(this).unbind("click");
        $(this).on("click", function(e){
            e.preventDefault();
            id = $(this).data("location");
            url = "/map/"+id;
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data){
                    $('#modalContainer').html(data.html);
                }
            })
        })
    });
}

function validate(type, data, input, usePopper){
    $.ajax({
        type: "GET",
        url: '/users/validate/'+type+'/'+data,
        success: function(data) {
            if(data.valid == true){
                if(usePopper){
                    var content = '';
                    popper(input, content, 'hide');
                }
                input.removeClass('is-invalid');
                popper(input, '', 'hide');
            }
            else {
                if(usePopper){
                    var content = data.popperContent;
                    popper(input, content, 'show');
                }
                input.addClass('is-invalid');
            }
        },
        error: function() {
        }
    });
}

function combineFields(targetField, name, surname, id){
    targetField.val(name+' '+surname+' ('+id+')');
}

function userSearchDropdown(field, target, linkClass, nameFrag){
    var timeout = null;
    var timeout_validate = null;
    var newFieldContainer = $('#'+nameFrag+'_fields');

    var newPersonName = $('#'+nameFrag+'_name');
    var newPersonSurname = $('#'+nameFrag+'_surname');
    var newPersonId = $('#'+nameFrag+'_mId');

    newPersonId.on('change textInput input', function(){
        clearTimeout(timeout_validate);
        timeout_validate = setTimeout(function(){
            validate('mId',newPersonId.val(), newPersonId, false);
        }, 500);
        combineFields(field, newPersonName.val(),newPersonSurname.val(),newPersonId.val());
    });

    newPersonName.on('change textInput input', function(){
        combineFields(field, newPersonName.val(),newPersonSurname.val(),newPersonId.val());
    });

    newPersonSurname.on('change textInput input', function(){
        combineFields(field, newPersonName.val(),newPersonSurname.val(),newPersonId.val());
    });

    field.on('change textInput input', function(){
        clearTimeout(timeout);

        var splitInput = field.val().split(' ');

        if (splitInput.length >= 0){
            newPersonName.val(splitInput[0]);
        }
        if (splitInput.length > 1) {
            newPersonSurname.val(splitInput[1]);
        }

        if (splitInput.length > 2){
            newPersonId.val(splitInput[2].replace('(','').replace(')',''));
        }



        timeout = setTimeout(function(){
            var query = field.val();

            $.ajax({
                type: "GET",
                url: '/users/search/' + query,
                data: { class: linkClass },
                success: function(data) {
                    if(data.html === ''){
                        target.html('no results');
                        newFieldContainer.fadeIn();
                    } else {
                        if(data.exists == true){
                            newFieldContainer.fadeOut();
                        } else {
                            newFieldContainer.fadeIn();
                        }
                        target.html(data.html);
                        userSearchLink(field, linkClass);
                    }
                },
                error: function() {
                }
            });
        }, 500);
    });
    field.on('focus', function(){
        target.fadeIn();
    });
    field.on('focusout', function(){
        target.fadeOut();
    });
}

function userSearchLink(field, linkClass) {
    $('.'+linkClass).each(function(index){
       $(this).on('click', function(e){
           e.preventDefault();
           field.val($(this).data('member'));
           field.trigger("change");
       })
    });
}

function popper(element, text, mode){
    element.attr("data-content", text);
    element.popover({html : true});
    element.popover(mode);
}

function validateDate(dayInput, monthInput, yearInput){
    $.each([dayInput, monthInput, yearInput], function(index){
        $(this).on('change keyup', function(){
            if($(this).val() != null){
                validateDateOnce(dayInput, monthInput, yearInput);
            }
        })
    })
}

function validateDates(earlierDate, laterDate, submitBtn){
    $.each([laterDate, earlierDate], function(){
        $.each($(this), function(){
            $(this).on('change input keyUp', function(){
                var laterDay = laterDate[0];
                var laterMonth = laterDate[1];
                var laterYear = laterDate[2];

                var earlierDay = earlierDate[0];
                var earlierMonth = earlierDate[1];
                var earlierYear = earlierDate[2];

                if(laterDay.val() !== '' && laterYear !== ''){
                    if(validateDateOnce(laterDay, laterMonth, laterYear, true) && validateDateOnce(earlierDay, earlierMonth, earlierYear, false)){
                        lDate = new Date(laterYear.val(), laterMonth.val()-1, laterDay.val());
                        eDate = new Date(earlierYear.val(), earlierMonth.val()-1, earlierDay.val());

                        if(eDate > lDate){
                            // alert('INVALID!');
                            laterDay.addClass('is-invalid');
                            laterMonth.addClass('is-invalid');
                            laterYear.addClass('is-invalid');
                            laterDay.popover({content: 'Datums nedrīkst būt agrāgs par iepriekšējo!', placement: 'top'});
                            laterDay.popover('show');
                            if(submitBtn !== null){
                                submitBtn.prop("disabled", true);
                            }
                        } else {
                            // alert('VALID!');
                            laterDay.removeClass('is-invalid');
                            laterMonth.removeClass('is-invalid');
                            laterYear.removeClass('is-invalid');
                            // laterDay.popover({content: '', placement: 'top'});
                            laterDay.popover('hide');
                            if(submitBtn !== null){
                                submitBtn.prop("disabled", false);
                            }
                        }

                    }
                }
                else {
                    // alert('NULL!');
                    laterDay.removeClass('is-invalid');
                    laterMonth.removeClass('is-invalid');
                    laterYear.removeClass('is-invalid');
                    // laterDay.popover({content: '', placement: 'top'});
                    laterDay.popover('hide');
                    if(submitBtn !== null){
                        submitBtn.prop("disabled", false);
                    }
                }

            })
        })
    })
}

function validateDateOnce(dayInput, monthInput, yearInput, allowNull) {
    var dateRegex = /^(?=\d)(?:(?:31(?!.(?:0?[2469]|11))|(?:30|29)(?!.0?2)|29(?=.0?2.(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(?:\x20|$))|(?:2[0-8]|1\d|0?[1-9]))([-.\/])(?:1[012]|0?[1-9])\1(?:1[6-9]|[2-9]\d)?\d\d(?:(?=\x20\d)\x20|$))?(((0?[1-9]|1[012])(:[0-5]\d){0,2}(\x20[AP]M))|([01]\d|2[0-3])(:[0-5]\d){1,2})?$/;
    var valid = dateRegex.test(dayInput.val() + "/" + monthInput.val() + "/" + yearInput.val());
    if(allowNull == true && (dayInput.val() === '' || monthInput.val() === '' || yearInput.val() === '')) {

        dayInput.removeClass('is-invalid');
        monthInput.removeClass('is-invalid');
        yearInput.removeClass('is-invalid');

        return true;
    } else if(!valid){
        dayInput.addClass('is-invalid');
        monthInput.addClass('is-invalid');
        yearInput.addClass('is-invalid');

        dayInput.popover({content: 'Datums nav ievadīts pareizi! Pārliecinaties par ievadītajiem datiem!', placement: 'top'});
        dayInput.popover('show');

        return false;
    } else {
        dayInput.removeClass('is-invalid');
        monthInput.removeClass('is-invalid');
        yearInput.removeClass('is-invalid');

        dayInput.popover('hide');

        return true;
    }
}

function emailTrick(inputs, domain, target){
    var values = [];
    $.each(inputs, function(index){
        $(this).on('change keyup textInput input', function(){
            $.each(inputs, function(index){
                values[index] = $(this).val();
            });
            target.attr("placeholder", values.join(".") + domain);
        })
    })
}