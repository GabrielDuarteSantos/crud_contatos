let formELm = $('#contact-form');
let submitBtnElm = formELm.find('button[type="submit"]');
let cancelUpdateBtn = $('button[type="reset"]');

formELm.find('input[name="landline_number"]').mask('(00) 0000-0000');
formELm.find('input[name="phone_number"]').mask('(00) 0 0000-0000');

let toastElm = $('.toast').toast({
    'delay': 3000,
});

let showToast = message => {

    toastElm.find('.toast-body').text(message);
    toastElm.toast('show');

};

let updatingContactId;

let initContactUpdate = contact => {

    updatingContactId = contact.id;

    for (let field in contact) {

        formELm.find(`input[name="${field}"]`).val(contact[field]);

    }

    formELm.find('input[name="landline_number"], input[name="phone_number"]').trigger('input');

    submitBtnElm.text('Atualizar');
    cancelUpdateBtn.show();

};

let cancelContactUpdate = () => {

    updatingContactId = null;

    submitBtnElm.text('Cadastrar');
    cancelUpdateBtn.hide();

};

let deleteContact = id => {

    return $.ajax({
        'url': `${location.href}api/contact/delete/${id}`,
        'method': 'PATCH',
    });

};

let listContacts = async () => {

    let contacts;

    try {

        contacts = await $.ajax(`${location.href}api/contacts`);

        if (!Array.isArray(contacts)) {

            throw new Error('Invalid response');

        }

    } catch (err) {

        console.error(err);

        showToast('Não foi possível listar os contatos!');

        return;

    }

    let contactRows = contacts.map(contact => {

        let formattedBirthdate = contact.birthdate.split('-').reverse().join('/');
        let contactNumber = contact.phone_number || contact.landline_number || '-';

        let elm = $(`
            <tr>
                <td>${contact.full_name}</td>
                <td>${formattedBirthdate}</td>
                <td>${contact.email}</td>
                <td>${contactNumber}</td>
                <td>
                    <button class="btn btn-secondary btn-sm update-contact-btn">Editar</button>
                </td>
                <td>
                    <button class="btn btn-danger btn-sm delete-contact-btn">Excluir</button>
                </td>
            </tr>
        `);

        elm.find('.update-contact-btn').on('click', () => {

            initContactUpdate(contact);

        });

        elm.find('.delete-contact-btn').on('click', async () => {

            try {

                await deleteContact(contact.id);

            } catch (err) {

                console.error(err);

                showToast('Ocorreu um erro ao excluir o contato!');

            }

            elm.remove();

            showToast(`Contato "${contact.full_name}" excluído com sucesso!`);

        });

        return elm;

    });

    $('#contacts-list').html(contactRows);

};

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

    contact.landline_number = contact.landline_number.replace(/\D/g, '');
    contact.phone_number = contact.phone_number.replace(/\D/g, '');

    // rota de cadastro suporta multiplos email/profissões por contato
    contact.emails = [contact.email];
    contact.occupations = [contact.occupation];

    delete contact.email;
    delete contact.occupation;

    submitBtnElm.attr('disabled', true);
    submitBtnElm.text('Cadastrando...');

    let requestOpts = {
        'url': `${location.href}api/contact`,
        'method': 'POST',
        'data': { contact },
    };

    if (updatingContactId) {

        requestOpts.method = 'PUT';

        contact.id = updatingContactId;

    }

    try {

        await $.ajax(requestOpts);

    } catch (err) {

        console.error(err);

        showToast('Não foi possível salvar o contato!');

        return;

    } finally {

        submitBtnElm.attr('disabled', false);
        submitBtnElm.text('Cadastrar');

        cancelContactUpdate();

    }

    inputElms.val('');

    showToast('Contato salvo com sucesso!');

    listContacts();

});

cancelUpdateBtn.on('click', () => {

    cancelContactUpdate();

});

listContacts();