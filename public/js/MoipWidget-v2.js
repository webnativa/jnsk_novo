//versão 2.1.0 - see more @ http://labs.moip.com.br/transparente

(function() {

	var jMoip;

	var falha = new Array();
	var errors = new Array();
	var indice = 0;
//	var URL = "https://desenvolvedor.moip.com.br/sandbox";
	var URL = "https://www.moip.com.br";

	var requestUrl = window.location;

	if (window.jQuery === undefined) {
		var scriptTag = document.createElement('script');
	    scriptTag.setAttribute("type","text/javascript");
	    scriptTag.setAttribute("src", URL + "/scripts/jquery-1.7.min.js");
	    scriptTag.onload = scriptLoadHandler;
	    scriptTag.onreadystatechange = function () {

	        if (this.readyState == 'complete' || this.readyState == 'loaded') {
	        	scriptLoadHandler();
	        }
	    };

	    (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(scriptTag);

	} else if(ComparaVersaoJS(window.jQuery.fn.jquery,'1.7') <= 0) {

		var scriptTag = document.createElement('script');
	    scriptTag.setAttribute("type","text/javascript");
	    scriptTag.setAttribute("src", URL + "/scripts/jquery-1.7.min.js");
	    scriptTag.onload = scriptLoadHandler;
	    scriptTag.onreadystatechange = function () {

	        if (this.readyState == 'complete' || this.readyState == 'loaded') {
	        	scriptLoadHandler();
	        }
	    };

		(document.getElementsByTagName("head")[0] || document.documentElement).appendChild(scriptTag);

	} else {
	    jMoip = window.jQuery;
		jMoip.getScript(URL + "/widget-fb/js/json2.js");
		jMoip.getScript(URL + "/scripts/util.js");
	}


	function scriptLoadHandler() {
	    jMoip = window.jQuery.noConflict(false);
		jMoip.getScript(URL + "/widget-fb/js/json2.js");
		jMoip.getScript(URL + "/scripts/util.js");
	}

	var MoipWidget = function(json) {

	if ( typeof jMoip == 'undefined' ) {
		scriptLoadHandler();
	}

	jMoip(document).ready(function(jMoip) {
	    param = {
			pagamentoWidget:{
				referer : requestUrl.href,
	        	token : jMoip("#MoipWidget").attr("data-token"),
	        	dadosPagamento: json
			}
	   };

	   var serviceUri = "/rest/pagamento?callback=?";

	   validarJson(param);

       if (errors.length > 0) {
    	   var callback_error = jMoip("#MoipWidget").attr("callback-method-error");
    	   __function = eval(callback_error);
    	   if (typeof window.__function == "function") {
	    	   __function(errors);
	    	   errors = new Array();
	    	   return;
       	   }
       }

       var conf = {
			url: URL + serviceUri,
			type: "GET",
			dataType: "json",
            scriptCharset: "utf-8",
			async: true,
			data: {"pagamentoWidget":JSON.stringify(param)},
			headers:{
				"Content-Type": "application/json",
				"Accept": "application/json"
			},
			success: function(data){

				if(data.StatusPagamento == "Sucesso"){
					var callback_success = jMoip("#MoipWidget").attr("callback-method-success");
					setarToken(data);
		            eval(callback_success)(data);
				} else {
					var callback_error = jMoip("#MoipWidget").attr("callback-method-error");
			        eval(callback_error)(data);
				}
			}
       };
   	   jMoip.ajax(conf);

      });
    };

	//### validações do json ###
	validarJson = function(json) {

		var token = json.pagamentoWidget.token;
		var pagamento = json.pagamentoWidget.dadosPagamento;

		validarToken(token);
		validarFormaDePagamento(pagamento);
	};

	validarToken = function(token) {

		if(naoInformou(token)) {
			adicionarErro(914, "Informe o token da Instrução");
		}
	};

	validarFormaDePagamento = function(pagamento) {

		var forma = pagamento.Forma;

		if(!jMoip.isFunction(window["validar" + forma])) {
			adicionarErro(900, "Forma de pagamento inválida");
			return;
		}

		var fn = window["validar" + forma];
		fn(pagamento);
	};

	//### validações por forma de pagamento ###
	validarCartaoCredito = function(pagamento) {
		validarParcelas(pagamento.Parcelas);
		validarPagamentoCartao(pagamento);
	};

	validarDebitoBancario = function(pagamento) {
		validarInstituicao(pagamento.Instituicao);
	};

	validarBoletoBancario = function(pagamento) {
	};

	//### validações dos dados de cartão de crédito ###
	validarPagamentoCartao = function(pagamento) {

		var cartao = pagamento.CartaoCredito;
		var cofre = pagamento.CartaoCredito.Cofre;
		var instituicao = pagamento.Instituicao;

		if (naoInformou(cartao)) {
			adicionarErro(905, "Informe os dados do cartão de crédito");
		}
		//cofre
		else if (informou(cofre)) {
			validarCofre(cartao, instituicao);
		//cartão de crédito
		} else {
			validarCartao(cartao, instituicao);
		}
	};

	validarInstituicao = function(instituicao) {

		if (naoInformou(instituicao)) {
			adicionarErro(901, "Informe a instituição de pagamento");
		}
	};

	validarCofre = function(cartao, instituicao) {

		if (naoInformou(cartao.Cofre)) {
			adicionarErro(913, "Informe o cofre a ser utilizado");
		}

		validarCvv(cartao.Numero, formatCvv(cartao.CodigoSeguranca, instituicao), instituicao);
	};

	validarCartao = function(cartao, instituicao) {

		var numero = cartao.Numero;

		if (informou(numero)) {
			cartao.Numero = String(numero).replace(/\D/g, "");
		}

		validarNumeroDoCartao(cartao, instituicao);
		validarCvv(cartao.Numero, formatCvv(cartao.CodigoSeguranca, instituicao), instituicao);
		validarDataDeExpiracao(cartao.Expiracao);
		validarPortador(cartao.Portador);
	};

	validarNumeroDoCartao = function(cartao, instituicao) {

		var numero = cartao.Numero;

		if (naoInformou(numero)) {
			adicionarErro(905, "Informe o número do cartão");

		} else {
			var qtdCaracteres = String(numero).length;

			if (instituicao == "Visa" && qtdCaracteres != 16) {
				adicionarErro(905, "Número de cartão inválido");
			}
			else if (instituicao == "Mastercard" && qtdCaracteres != 16) {
				adicionarErro(905, "Número de cartão inválido");
			}
			else if (instituicao == "AmericanExpress" && (qtdCaracteres < 15 || qtdCaracteres > 16)) {
				adicionarErro(905, "Número de cartão inválido");
			}
			else if (instituicao == "Diners" && qtdCaracteres != 14) {
				adicionarErro(905, "Número de cartão inválido");
			}
			else if (instituicao == "Hipercard" && (qtdCaracteres < 13 || qtdCaracteres > 19 || qtdCaracteres == 17 ||qtdCaracteres == 18)) {
				adicionarErro(905, "Número de cartão inválido");
			}
			else if (instituicao == "Elo" && qtdCaracteres != 16) {
                adicionarErro(905, "Número de cartão inválido");
            }
            else if (instituicao == "Hiper" && qtdCaracteres != 16) {
				adicionarErro(905, "Número de cartão inválido");
			}
		}
	};

	validarCvv = function(numero, cvv, instituicao) {

		if (informou(cvv)) {
			var qtdCaracteres = String(cvv).length;

			if (isNaN(cvv)) {
				adicionarErro(907, "Código de segurança inválido");
			}
			else if (isAmex(instituicao) && qtdCaracteres != 4) {
				adicionarErro(907, "Código de segurança inválido");
			}
			else if (!isAmex(instituicao) && qtdCaracteres != 3) {
				adicionarErro(907, "Código de segurança inválido");
			}
		}
	};

	validarParcelas = function(parcelas){

		if (naoInformou(parcelas)) {
			adicionarErro(902, "Informe a quantidade de parcelas");

		} else if (isNaN(parcelas) || parcelas < 1 || parcelas > 12){
				adicionarErro(902, "Quantidade de parcelas deve ser entre 1 e 12");
		}
	};

	validarPortador = function(portador){

		if (naoInformou(portador)) {
			adicionarErro(908, "Informe os dados do portador do cartão");

		} else {
			if (naoInformou(portador.Nome)) {
				adicionarErro(909, "Informe o nome do portador como está no cartão");
			}

			if(naoInformou(portador.DataNascimento)) {
				adicionarErro(910, "Informe a data de nascimento do portador");

			} else if(!dataDeNascimentoEhValida(portador.DataNascimento)) {
				adicionarErro(910, "Data de nascimento do portador deve estar no formato DD/MM/AAAA");
			}

			if(naoInformou(portador.Telefone)) {
				adicionarErro(911, "Informe o telefone do portador");

			} else if(!telefoneEhValido(portador.Telefone)) {
				adicionarErro(911, "O telefone do portador é inválido");
			}

			if(naoInformou(portador.Identidade)) {
				adicionarErro(912, "Informe o CPF do portador");

			} else if(!cpfEhValido(portador.Identidade)) {
				adicionarErro(912, "O CPF do portador inválido");
			}
		}
	};

	telefoneEhValido = function(telefone) {

		telefone = String(telefone).replace(/\D/g, "");

		if (telefone.length < 8) {
			return false;
		}
		return true;
	};

	cpfEhValido = function(cpf) {

		cpf = String(cpf).replace(/\D/g, "");

	    if (cpf.length != 11) {
	          return false;
	    }
    	return true;
    };

	dataDeNascimentoEhValida = function(data) {

		barras = data.split("/");
		if (barras.length == 3) {
	        dia = barras[0];
	        mes = barras[1];
	        ano = barras[2];

	        if(!diaEhValido(dia) || !mesEhValido(mes) || !anoEhValido(ano)) {
	        	return false;

	        } else {
	        	return true;
	        }
		}
		return false;
    };

	validarDataDeExpiracao = function(data) {

		var dataDeExpiracao = String(data);

		if(naoInformou(dataDeExpiracao)) {
			adicionarErro(906, "Informe a data de expiração do cartão");

		} else if(dataDeExpiracao.indexOf("/") < 0) {
			adicionarErro(906, "Data de expiração deve estar no formato 'MM/AA'");
			return;

		} else {
			partes = dataDeExpiracao.split("/");

			if(partes.length == 2) {
				mes = partes[0];
				ano = partes[1];

				if (!mesEhValido || !anoEhValido) {
					adicionarErro(906, "Data de expiração deve estar no formato 'MM/AA'");
				}
			} else {
				adicionarErro(906, "Data de expiração deve estar no formato 'MM/AA'");
			}
		}
	};

	diaEhValido = function(dia) {
    	return !isNaN(dia) && dia >= 1 && dia <= 31;
    };

    mesEhValido = function(mes) {
    	return !isNaN(mes) && mes >= 1 && mes <= 12;
    };

    anoEhValido = function(ano) {
    	return !isNaN(ano) && ano.length == 4;
    };

    informou = function(dado) {
    	return !naoInformou(dado);
    };

    naoInformou = function(dado) {
    	return dado == undefined || String(dado) == '';
    };

    setarToken = function(data) {
		data["url"] = URL + "/Instrucao.do?token=" + jMoip("#MoipWidget").attr("data-token");
	};

    isAmex = function(instituicao){
		return instituicao == "AmericanExpress"
    }

    formatCvv = function(cvv, instituicao) {

		if (cvv.length < 3 && !isAmex(instituicao)) {
			return concatZeros(cvv, 3);
		}

		if (cvv.length < 4 && isAmex(instituicao)) {
			return concatZeros(cvv, 4);
		}

		if (cvv.length > 3 && !isAmex(instituicao)) {
			return cvv.substring(cvv.length() - 3, cvv.length());
		}

		if (cvv.length > 4 && isAmex(instituicao)) {
			return cvv.substring(cvv.length() - 4, cvv.length());
		}

		return cvv;
	}

   concatZeros = function(cvv, maxPositions) {
		while (cvv.length < maxPositions) {
			cvv = "0".concat(cvv);
		}
		return cvv;
	}


	adicionarErro = function(codigoErro, mensagemErro) {
		var erro = {
			Codigo: codigoErro,
			Mensagem: mensagemErro
		};
		errors.push(erro);
	};

    function ComparaVersaoJS(a, b) {

        if (a === b)
            return 0;

        var a_components = a.split(".");
        var b_components = b.split(".");

        var len = Math.min(a_components.length, b_components.length);

        for (var i = 0; i < len; i++)
        {
            if (parseInt(a_components[i]) > parseInt(b_components[i]))
                return 1;

            if (parseInt(a_components[i]) < parseInt(b_components[i]))
                return -1;
        }

        if (a_components.length > b_components.length)
            return 1;

        if (a_components.length < b_components.length)
            return -1;

        return 0;
    }

	var parcelamento;
	var MoipUtil = {
			calcularParcela: function(settings) {
				parcelamento = settings;
				var request = { "token": jMoip("#MoipWidget").attr("data-token"), "instituicao" : parcelamento.instituicao };
				var conf = {
						url: URL + "/rest/pagamento/consultarparcelamento?callback=?",
						type: "GET",
						dataType: "json",
                        scriptCharset: "utf-8",
						async: true,
						data: request,
						headers:{
							"Content-Type": "application/json",
							"Accept": "application/json"
						},
						success: function(data){
							eval(parcelamento.callback)(data);
						}
		    	   };
				jMoip.ajax(conf);
			}
	};

	window.MoipWidget = MoipWidget;
	window.MoipUtil = MoipUtil;

})();