//Agenda esta separado no arquvo calendar.js

// Deletando evento e orçamento
function confirmDeleteEventBudget(idEvent, titleEvent) {
    if (titleEvent === "Realizar Orçamento") {
        $.confirm({
            title: 'Atenção!',
            content: 'Realmente deseja excluir esse evento e o orçamento veiculado a ele?',
            type: 'red',
            buttons: {
                omg: {
                    text: 'Sim',
                    btnClass: 'btn-red',
                    action: function () {
                        $.ajax({
                            url: "/agenda/calendario/apagar",
                            method: "POST",
                            data: { idEventBudget: idEvent },
                            success: function (retorna) { retorna['sit'] ? location.reload() : $("#msg-cad").html(retorna['msg']); },
                            error: function () { toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!'); }
                        });
                    }
                },
                close: {
                    text: 'Não',
                    action: function () {
                        $.confirm({
                            title: 'Atenção!',
                            content: 'Realmente deseja excluir somente o evento?',
                            type: 'red',
                            buttons: {
                                omg: {
                                    text: 'Sim',
                                    btnClass: 'btn-red',
                                    action: function () {
                                        $.ajax({
                                            url: "/agenda/calendario/apagar",
                                            method: "POST",
                                            data: { idEvent: idEvent },
                                            success: function (retorna) { retorna['sit'] ? location.reload() : $("#msg-cad").html(retorna['msg']); },
                                            error: function () { toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!'); }
                                        });
                                    }
                                },
                                close: {
                                    text: 'Não',
                                }
                            }
                        });
                    }
                }
            }
        });
    } else {
        $.confirm({
            title: 'Atenção!',
            content: 'Realmente deseja excluir esse evento?',
            type: 'red',
            buttons: {
                omg: {
                    text: 'Sim',
                    btnClass: 'btn-red',
                    action: function () {
                        $.ajax({
                            url: "/agenda/calendario/apagar",
                            method: "POST",
                            data: { idEvent: idEvent },
                            success: function (retorna) { retorna['sit'] ? location.reload() : $("#msg-cad").html(retorna['msg']); },
                            error: function () { toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!'); }
                        });
                    }
                },
                close: {
                    text: 'Não',
                }
            }
        });
    }
}

// Atualizar status 
function confirmUpdateStatusRecord(data, url, idTable, msgSuccess, msgError) {
    $.confirm({
        title: 'Atenção!',
        content: 'Realmente deseja atualizar o status esse registro?',
        type: 'orange',
        buttons: {
            omg: {
                text: 'Sim',
                btnClass: 'btn-orange',
                action: function () {
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: { data: data },
                        success: function (retunAjax) {
                            if (retunAjax) {
                                toastr.success(msgSuccess);
                                $(idTable).DataTable().ajax.reload();
                            } else { toastr.error(msgError); }
                        },
                        error: function () {
                            toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!');
                        }
                    });
                }
            },
            close: {
                text: 'Não',
            }
        }
    });
}

// Funcção global
function confirmDeleteRecord(data, url, idTable, msgSuccess, msgError) {
    $.confirm({
        title: 'Atenção!',
        content: 'Realmente deseja excluir esse registro?',
        type: 'red',
        buttons: {
            omg: {
                text: 'Sim',
                btnClass: 'btn-red',
                action: function () {
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: { data: data },
                        success: function (retunAjax) {
                            if (retunAjax) {
                                toastr.success(msgSuccess);
                                $(idTable).DataTable().ajax.reload();
                            } else { toastr.error(msgError); }
                        },
                        error: function () {
                            toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!');
                        }
                    });
                }
            },
            close: {
                text: 'Não',
            }
        }
    });
}
