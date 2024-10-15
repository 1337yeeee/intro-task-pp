STATUSES = {
    0: 'Pending',
    1: 'In progress',
    2: 'Completed',
    3: 'Canceled',
    4: 'Fail'
};

MODES = {
    0: 'Manual',
    1: 'Auto'
};

function parseDate(inDate) {
    return inDate;
}

$(document).ready(function() {
    $.ajax({
        url: '/api/orders', // URL вашего API
        method: 'GET',
        dataType: 'json', // ожидаем JSON ответ
        success: function(data) {
            // Очистим тело таблицы перед добавлением новых данных
            $('#orders-table tbody').empty();

            // Перебираем массив данных и добавляем строки в таблицу
            $.each(data, function(index, order) {
                orderDate = parseDate(order.created_at)
                $('#orders-table tbody').append(`
                    <tr>
                        <td>${order.id}</td>
                        <td>${order.user.first_name}</td>
                        <td class="link">${order.link}</td>
                        <td>${order.quantity}</td>
                        <td class="service">
                            <span class="label-id">${order.service.id}</span>${order.service.name}
                        </td>
                        <td>${STATUSES[order.status]}</td>
                        <td>${MODES[order.mode]}</td>
                        <td>${orderDate}</td>
                    </tr>
                `);
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Ошибка при загрузке данных: ', textStatus, errorThrown);
            // Обработка ошибок
        }
    });
});
