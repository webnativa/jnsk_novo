jQuery.fn.brTelMask = function () {

    return this.each(function () {
        var el = this;
        $(el).focus(function () {
            $(el).mask("(99) 9999-9999?9");
        });

        $(el).focusout(function () {
            var phone, element;
            element = $(el);
            element.unmask();
            phone = element.val().replace(/\D/g, '');
            if (phone.length > 10) {
                element.mask("(99) 99999-999?9");
            } else {
                element.mask("(99) 9999-9999?9");
            }
        });
    });
};

CKEDITOR.editorConfig = function( config ) {
        config.extraPlugins = 'youtube';
};

var editor = CKEDITOR.replace( 'editor1', {
    language: 'pt-br',
    height: 500,
    toolbarCanCollapse: true,
    filebrowserBrowseUrl : '/public/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl : '/public/ckfinder/ckfinder.html?type=Images',
    filebrowserFlashBrowseUrl : '/public/ckfinder/ckfinder.html?type=Flash',
    filebrowserUploadUrl : '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl : '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
});
CKFinder.setupCKEditor( editor, '../' );


$(document).ready(function () {
    
    $('.colorp').colorpicker();
    
    $('#botao_sim_confirmar').click(function () {
        $('#confirmar_envio').modal('hide');
        $('#pedido-form').submit();
    });
    
    $('#table_permissoes tr').click(function () {
        
        var id = $(this).attr("permissao_id");
        var is_cheked = document.getElementById("permissao_id_"+id).checked;
        
        if(is_cheked){
            $("#permissao_id_"+id).prop("checked", false);
        }
        
        if(!is_cheked){
            $("#permissao_id_"+id).prop("checked", true);
        }
        
    });
    
    $('#clinicas_mark').multiSelect();
    
    $('#envia_mensagem').click(function () {
        $('#confirmar_envio').modal('hide');
        $('#acao_massa').submit();
    });
    
    $('.active_tab').click(function () {
        
        var aba = $(this).attr('aba'); 
        $('.nav-tabs a[href="#tab-'+aba+'"]').tab('show');
        
    });

    $("#marcar_todos").change(function () {

        if (this.checked) {
            $('.ckecklist').prop('checked', true);
        } else {
            $('.ckecklist').prop('checked', false);
        }

    });
    
    $(".busca-clinicas").autocomplete({
        minLength: 2,
        source: "/redecredenciada/get-clinicas"
       
    });
    
    $('.data_c').datepicker({format: 'dd/mm/yyyy'});
    
    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
    
    $('.data_validacao_voucher').datepicker( {
                format: 'dd/mm/yyyy'
    }
    );

    $(".get-usuarios").autocomplete({
        source: "/gestao/usuarios/ajax",
        minLength: 2,
        select: function(event, ui) {
            if(!ui.item){
                return false;
            }
            
            $(".pk_user").val(ui.item.id);
            
            var html = "<strong> Código: </strong>" + ui.item.id;
            html += ", <strong> CPF: </strong>" + ui.item.cpf;
            html += ", <strong> RG: </strong>" + ui.item.rg;
            html += ", <strong> e-mail: </strong>" + ui.item.email;
            html += ", <strong> Telefone: </strong>" + ui.item.telefone;
            
            $("#dados_usuario").addClass('alert alert-warning').html(html);
            
        }
    });
    
    $.fn.datepicker.dates['en'] = {
        days: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo"],
        daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab", "Dom"],
        daysMin: ["Do", "Se", "Te", "Qua", "Qui", "Se", "Sa", "Do"],
        months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
        monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
        today: "Hoje",
        clear: "Limpar"
    };

    var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };


    var elem = document.querySelector('.js-switch');
    var switchery = new Switchery(elem, {color: '#1AB394'});

    $("#id_cep").mask('00000-000');
    $(".cnpj_mask, #id_cnpj").mask('99.999.999/9991-99');
    $(".date_mask").mask('99/99/9999');

    $("#id_cpf, .cpf_mask").mask('999.999.999-99');
    $('.mask_valor').mask('000.000.000.000.000,00', {reverse: true});
    $('#id_celular, #id_telefone, .telefone_mask').mask(SPMaskBehavior, spOptions);

    $("#id_data_nascimento").mask('00/00/0000');
    $("#id_cep").on('focusout', function () {

        if ($(this).val() == "" || $(this).val() == " ") {
            return false;
        }

        var str = $(this).val();

        $.ajax({
            type: "GET",
            dataType: 'json',
            data: {'cep': $(this).val()},
            url: "http://cep.correiocontrol.com.br/" + str.replace("-", "") + ".json",
            beforeSend: function () {
                $(".lbuscacep").html("<span  class='marca_texto_vermelho'> Aguarde, configurando endereço...</span>");
            },
            success: function (response) {

                $(".lbuscacep").html("");

                $("#id_endereco").val(response.logradouro);
                $("#id_bairro").val(response.bairro);

                $("#id_estado").val(response.uf);

                var uf = response.uf;
                $("#id_estado option").filter(function () {
                    return $(this).text() == uf;
                }).attr('selected', true);

                $("#id_estado").trigger('change');

                $('.endereco_empresa').val(response.logradouro + ", " + response.bairro + ", " + response.localidade + " - " + response.uf);


            },
            error: function () {
                $(".lbuscacep").html("");
            },
            timeout: 10000
        });

    });
    
    $("#id_estado").on('change', function () {

        if ($(this).val() == "" || $(this).val() == " ") {
            return false;
        }

        $.ajax({
            type: "GET",
            dataType: 'json',
            data: {'uf': $(this).val()},
            url: "/get-cidades/",
            beforeSend: function () {
                $(".lbuscacidade").html(" <span  class='marca_texto_vermelho'> Aguarde ...</span>");
            },
            success: function (response) {

                $(".lbuscacidade").html("");

                if (response.cidades) {

                    $("#id_cidade").empty();

                    var options = $("#id_cidade");
                    $.each(response.cidades, function () {
                        options.append($("<option />").val(this.pk).text(this.nome));
                    });

                }

            },
            error: function () {
                $(".lbuscacidade").html("");
            },
            timeout: 10000
        });

    });
    
    
    $(".ajax_cidade").on('change', function () {

        if ($(this).val() == "") {
            return false;
        }

        $.ajax({
            type: "GET",
            dataType: 'json',
            data: {'cidade_id': $(this).val()},
            url: "/bairros/ajax/",
            beforeSend: function () {
                $(".lbuscacidade").html(" <span  class='marca_texto_vermelho'> Aguarde ...</span>");
            },
            success: function (response) {

                $(".lbuscacidade").html("");
                   
                if (response.bairros) {

                    $(".combo_bairro").empty();

                    var options = $(".combo_bairro");
                    $.each(response.bairros, function () {
                         
                        options.append($("<option />").val(this.pk).text(this.nome));
                    });

                }

            },
            error: function () {
                $(".lbuscacidade").html("");
            },
            timeout: 10000
        });

    });
    
    $('#btn_confirmar_remocao').click(function () {
        $('#confirmar_remocao').modal('hide');
        $('#form_remover_numeros_invalidos').submit();
    });

    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {allow_single_deselect: true},
        '.chosen-select-no-single': {disable_search_threshold: 10},
        '.chosen-select-no-results': {no_results_text: 'Oops, nada encontrado!'},
        '.chosen-select-width': {width: "95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

    

});

/* Máscaras ER */
function mascara(o, f) {
    v_obj = o
    v_fun = f
    setTimeout("execmascara()", 1)
}
function execmascara() {
    v_obj.value = v_fun(v_obj.value)
}
function mcep(v) {
    v = v.replace(/\D/g, "")                    //Remove tudo o que não é dígito
    v = v.replace(/^(\d{5})(\d)/, "$1-$2")         //Esse é tão fácil que não merece explicações
    return v
}
function mtel(v) {
    v = v.replace(/\D/g, "")                 //Remove tudo o que não é dígito
    v = v.replace(/^(\d\d)(\d)/g, "($1) $2") //Coloca parênteses em volta dos dois primeiros dígitos
    v = v.replace(/(\d{4})(\d)/, "$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
    return v
}
function cnpj(v) {
    v = v.replace(/\D/g, "")                           //Remove tudo o que não é dígito
    v = v.replace(/^(\d{2})(\d)/, "$1.$2")             //Coloca ponto entre o segundo e o terceiro dígitos
    v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3") //Coloca ponto entre o quinto e o sexto dígitos
    v = v.replace(/\.(\d{3})(\d)/, ".$1/$2")           //Coloca uma barra entre o oitavo e o nono dígitos
    v = v.replace(/(\d{4})(\d)/, "$1-$2")              //Coloca um hífen depois do bloco de quatro dígitos
    return v
}
function mcpf(v) {
    v = v.replace(/\D/g, "")                    //Remove tudo o que não é dígito
    v = v.replace(/(\d{3})(\d)/, "$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d)/, "$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
                                                //de novo (para o segundo bloco de números)
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    return v
}
function mdata(v) {
    v = v.replace(/\D/g, "");                    //Remove tudo o que não é dígito
    v = v.replace(/(\d{2})(\d)/, "$1/$2");
    v = v.replace(/(\d{2})(\d)/, "$1/$2");

    v = v.replace(/(\d{2})(\d{2})$/, "$1$2");
    return v;
}
function mtempo(v) {
    v = v.replace(/\D/g, "");                    //Remove tudo o que não é dígito
    v = v.replace(/(\d{1})(\d{2})(\d{2})/, "$1:$2.$3");
    return v;
}
function mhora(v) {
    v = v.replace(/\D/g, "");                    //Remove tudo o que não é dígito
    v = v.replace(/(\d{2})(\d)/, "$1h$2");
    return v;
}
function mrg(v) {
    v = v.replace(/\D/g, "");                                      //Remove tudo o que não é dígito
    v = v.replace(/(\d)(\d{7})$/, "$1.$2");    //Coloca o . antes dos últimos 3 dígitos, e antes do verificador
    v = v.replace(/(\d)(\d{4})$/, "$1.$2");    //Coloca o . antes dos últimos 3 dígitos, e antes do verificador
    v = v.replace(/(\d)(\d)$/, "$1-$2");               //Coloca o - antes do último dígito
    return v;
}
function mnum(v) {
    v = v.replace(/\D/g, "");                                      //Remove tudo o que não é dígito
    return v;
}
function mvalor(v) {
    v = v.replace(/\D/g, "");//Remove tudo o que não é dígito
    v = v.replace(/(\d)(\d{8})$/, "$1.$2");//coloca o ponto dos milhões
    v = v.replace(/(\d)(\d{5})$/, "$1.$2");//coloca o ponto dos milhares

    v = v.replace(/(\d)(\d{2})$/, "$1,$2");//coloca a virgula antes dos 2 últimos dígitos
    return v;
}

