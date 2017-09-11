$(document).ready(function () {

    $("#resultado").hide();

    $('#showXml').modal('toggle');

    $('#tabs a:first').tab('show');
    
    $("#form_pagamento_voucher input[type='radio']").change(function(){
        
        calcular();
    });
    
    $("#sendToMoip").click(function () {

        $("#tipo_pagamento").val('cartao');

        var cartao_selecionado = $("#form_pagamento_voucher input[type='radio']:checked").val();

        $("#erro_pagamento").show();

        if (cartao_selecionado === undefined) {
            $("#erro_pagamento").append("Selecione uma Bandeira");
            return false;
        }
        $("#erro_pagamento").html('');
        $("#erro_pagamento").hide();

        $("#mensagem_processando").show();
        sendToCreditCard();
    });

    $("#boleto").click(function () {
        $("#tipo_pagamento").val('boleto');
        $("#mensagem_processando").show();
        sendToBoleto();
    });

    $("#debit").click(function () {
        $("#tipo_pagamento").val('debito');
        $("#mensagem_processando").show();
        sendToDebit();
    });

});

calcular = function () {
    var settings = {
        cofre: '',
        instituicao: $("#form_pagamento_voucher input[type='radio']:checked").val(),
        callback: "retornoCalculoParcelamento"
    };
    
    MoipUtil.calcularParcela(settings);
};

retornoCalculoParcelamento = function (data) {
    
    $("#info_parcelamento").html('');
    var html_info = '';
    
    for (var i in data.parcelas) {
        
        dados = data.parcelas[i];
        
        html_info = "<div class='info_par'> <strong>" + dados.quantidade + "X </strong> " + " de " 
                + dados.valor + " - <strong> Total: R$ </strong> " + dados.valor_total + "</div>";
        
        $("#info_parcelamento").append(html_info);
        
    }
    
};

sendToCreditCard = function () {

    var settings = {
        "Forma": "CartaoCredito",
        "Instituicao": $("#form_pagamento_voucher input[type='radio']:checked").val(),
        "Parcelas": $("input[name=Parcelas]").val(),
        "Recebimento": "AVista",
        "CartaoCredito": {
            "Numero": $("input[name=Numero]").val(),
            "Expiracao": $("input[name=Expiracao]").val(),
            "CodigoSeguranca": $("input[name=CodigoSeguranca]").val(),
            "Portador": {
                "Nome": $("input[name=Portador]").val(),
                "DataNascimento": $("input[name=DataNascimento]").val(),
                "Telefone": $("input[name=Telefone]").val(),
                "Identidade": $("input[name=CPF]").val()
            }
        }
    };

    MoipWidget(settings);
};

sendToDebit = function () {
    var settings = {
        "Forma": "DebitoBancario",
        "Instituicao": "BancoDoBrasil"
    };

    MoipWidget(settings);
    $("#link-debito").append("<a href='https://www.moip.com.br/Instrucao.do?token=" + $("#MoipWidget").attr("data-token") + "' target='_blank'>Abrir</a>");

};


sendToBoleto = function () {
    var settings = {
        "Forma": "BoletoBancario"
    };

    MoipWidget(settings);
};

var sucesso = function (data) {

    $("#mensagem_processando").hide();

    var resposta = data.Mensagem +
            '\n\n Status: ' + data.Status +
            '\n ID Moip: ' + data.CodigoMoIP +
            '\n Valor Pago: ' + data.TotalPago +
            '\n Taxa Moip: ' + data.TaxaMoIP +
            '\n Cod. Operadora: ' + data.CodigoRetorno;
    
    var tipo_pagamento = $("#tipo_pagamento").val();

    if (tipo_pagamento == 'boleto') {
        window.open(data.url, '_blank');
        window.location.href = "/carrinho/sucesso/";
    }

    if (tipo_pagamento == 'cartao') {
        window.location.href = "/carrinho/sucesso/";
    }
};

var erroValidacao = function (data) {
    $("#mensagem_processando").hide();
    alert("Erro !\n\n" + JSON.stringify(data));

    var dados_erro = JSON.stringify(data);
    
    $("#erro_pagamento").show();

    $("#erro_pagamento").html('');

    var mensagem_indefinida = false;

    for (var i in data) {
        if (data[i].Mensagem === undefined) {
            mensagem_indefinida = true;
        } else {
            $("#erro_pagamento").append(data[i].Mensagem + ' <br> ');
        }
    }

    if (mensagem_indefinida) {
        $("#erro_pagamento").append(data.Mensagem);
    }
};