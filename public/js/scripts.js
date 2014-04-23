/**
 * efeito alert
 */

$(function() {
    // pegar elemento com corpo da mensagem
    var corpo_alert = $("#alert-message");
    // verificar se o elemento esta presente na página
    if (corpo_alert.length)
        corpo_alert.fadeOut().fadeIn().fadeOut().fadeIn();
});