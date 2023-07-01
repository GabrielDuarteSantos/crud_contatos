let toastElm = $('.toast').toast({
    'delay': 3000,
});

let showToast = message => {

    toastElm.find('.toast-body').text(message);
    toastElm.toast('show');

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
                    <button class="btn btn-danger btn-sm delete-contact-btn">Excluir</button>
                </td>
            </tr>
        `);

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

    // rota de cadastro suporta multiplos email/profissões por contato
    contact.emails = [contact.email];
    contact.occupations = [contact.occupation];

    delete contact.email;
    delete contact.occupation;

    submitBtnElm.attr('disabled', true);
    submitBtnElm.text('Cadastrando...');

    try {

        await $.post(`${location.href}api/contact`, { contact });

    } catch (err) {

        console.error(err);

        showToast('Não foi possível cadastrar o contato!');

        return;

    } finally {

        submitBtnElm.attr('disabled', false);
        submitBtnElm.text('Cadastrar');

    }

    inputElms.val('');

    showToast('Contato cadastrado com sucesso!');

    listContacts();

});

listContacts();