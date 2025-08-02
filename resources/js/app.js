import './bootstrap'; 
import $ from 'jquery';
window.$ = window.jQuery = $;


$(document).ready(function() {
    $('#clienteSelect').on('change', function() {

        const cliente = {
            id: $(this).val(),
            nome: $(this).find('option:selected').text().split('-')[1].trim().split('/')[0].trim(),
            cpf: $(this).find('option:selected').text().split('/')[1].trim()
        }

        $('#clienteInfo').html(`
            <div class="alert alert-info">
                <strong>Cliente Selecionado:</strong>
                <strong>Nome:</strong> ${cliente.nome} <br>
                <strong>CPF:</strong> ${cliente.cpf}
            </div>
        `);

    })

});
