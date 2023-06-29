let toastElm = $('.toast').toast({
    'delay': 3000,
});

let showToast = message => {

    toastElm.find('.toast-body').text(message);
    toastElm.toast('show');

};

let listContacts = async () => {

    let contacts;

    try {

        contacts = await $.ajax(`${location.href}contacts`);

    } catch (err) {

        console.log(err);

        showToast('Ocorreu um erro ao listar os contatos!');

        return;

    }

    let contactRows = contacts.map(contact => {

        let formattedBirthdate = contact.birth_date.split('-').reverse().join('/');
        let contactNumber = contact.phone_number || contact.landline_number || '-';

        return $(`
            <tr>
                <td>${contact.full_name}</td>
                <td>${formattedBirthdate}</td>
                <td>${contact.email}</td>
                <td>${contactNumber}</td>
            </tr>
        `);

    });

    $('#contacts-list').html(contactRows);

};

let formELm = $('#contact-form');
let submitBtnElm = formELm.find('button[type="submit"]');

formELm.on('submit', async event => {

    event.preventDefault();

    let contact = {};
    let inputElms = formELm.find('input');

    let isValid = inputElms.toArray().every(inputElm => {

        let value;

        if (inputElm.getAttribute('type') === 'checkbox') {

            value = inputElm.checked;

        } else {

            value = inputElm.value.trim();

            if (!value && inputElm.getAttribute('required')) {
    
                return false;
    
            }

        }

        let key = inputElm.getAttribute('name');

        contact[key] = value;

        return true;

    });

    if (!isValid) {

        showToast('Preencha todos os campos obrigatórios!');

        return;

    }

    contact.emails = [contact.email];

    delete contact.email;

    submitBtnElm.attr('disabled', true);
    submitBtnElm.text('Cadastrando...');

    let createResponse;

    try {

        createResponse = await $.post(`${location.href}contact`, { contact });

    } catch (err) {

        console.log(err);

        showToast('Ocorreu um erro ao cadastrar o contato!');

        return;

    } finally {

        submitBtnElm.attr('disabled', false);
        submitBtnElm.text('Cadastrar');

    }
    
    console.log(createResponse);

    inputElms.val('');

    showToast('Contato cadastrado com sucesso!');

    listContacts();

});

listContacts();