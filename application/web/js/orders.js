STATUSES = {
    0: 'Pending',
    1: 'In progress',
    2: 'Completed',
    3: 'Canceled',
    4: 'Error'
};

STATUSES_N = {
    'Pending': 0,
    'In progress': 1,
    'Completed': 2,
    'Canceled': 3,
    'Error': 4,
};

MODES = {
    0: 'Manual',
    1: 'Auto'
};

$(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);

    const searchQuery = urlParams.get('search');
    const searchType = urlParams.get('search-type');
    const status = urlParams.get('status');
    const mode = urlParams.get('mode');
    if(searchQuery) $('#search-input').val(searchQuery);
    if(searchType) $('#search-type').val(searchType);
    if(Number.isInteger(STATUSES_N[status])) {
        $('#nav-tabs li[data-type="status"]').removeClass('active');
        $(`#nav-tabs li[data-type="status"][data-status="${status}"]`).addClass('active');
    }
    if(mode) {
        $('#mode-list li').removeClass('active');
        $('#mode-list li[data-mode="' + mode + '"]').addClass('active');
    }

    $('#search-button').click(function(event) {
        event.preventDefault();

        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        const newParams = new URLSearchParams();

        if (status) {
            newParams.set('status', status);
        }

        const search = $('#search-input').val();
        const searchType = $('#search-type').val();

        if (search) {
            newParams.set('search', search);
        }

        if (searchType) {
            newParams.set('search-type', searchType);
        }

        window.location.href = '/orders?' + newParams.toString();
    });

    $('#nav-tabs li[data-type="status"]').on('click', function() {
        const selectedStatus = $(this).data('status');

        if (selectedStatus) {
            urlParams.set('status', selectedStatus);
        } else {
            urlParams.delete('status');
        }

        urlParams.delete('service_id');
        urlParams.delete('mode');

        const newUrl = window.location.pathname + '?' + urlParams.toString();
        window.history.pushState({ path: newUrl }, '', newUrl);

        $('#nav-tabs li[data-type="status"]').removeClass('active');
        $(this).addClass('active');

        fetchOrdersAndUpdateTable(urlParams);
        fetchAndUpdateServices(urlParams);

        return false;
    });

    $('#mode-list li').on('click', function(event) {
        event.preventDefault()

        const selectedMode = $(this).data('mode')

        if(Number.isInteger(selectedMode)) {
            urlParams.set('mode', selectedMode);
        } else {
            urlParams.delete('mode');
        }

        const newUrl = window.location.pathname + '?' + urlParams.toString();
        window.history.pushState({ path: newUrl }, '', newUrl);

        $('#mode-list li').removeClass('active');
        $(this).addClass('active');

        fetchOrdersAndUpdateTable(urlParams);
        fetchAndUpdateServices(urlParams);
    });

    fetchOrdersAndUpdateTable(urlParams);
    fetchAndUpdateServices(urlParams);

});

function fetchOrdersAndUpdateTable(urlParams) {
    const status = urlParams.get('status');
    const mode = urlParams.get('mode');
    const searchQuery = urlParams.get('search');
    const searchType = urlParams.get('search-type');
    const serviceId = urlParams.get('service_id');
    const perPage = urlParams.get('limit');
    const page = urlParams.get('page');

    const requestData = {};
    if(status) requestData.status = status;
    if(mode) requestData.mode = mode;
    if(searchQuery) requestData.search = searchQuery;
    if(searchType) requestData['search-type'] = searchType;
    if(serviceId) requestData.service_id = serviceId;
    if(perPage) requestData.limit = perPage;
    if(page) requestData.page = page;

    $.ajax({
        url: '/api/orders',
        method: 'GET',
        data: requestData,
        dataType: 'json',
        success: function(data) {
            updateTable(data.orders);
            let page = data.page;
            let perPage = data.per_page;
            let totalCount = data.total_count;
            let fromPage = (page-1) * perPage + 1;
            let toPage = Math.min((page) * perPage, totalCount)

            $('#pagination-counters').text(`${fromPage} to ${toPage} of ${totalCount}`)
            $('#pagination').html(data.pagination);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Ошибка при загрузке данных: ', textStatus, errorThrown);
        }
    });
}

function parseDate(timestamp) {
    const date = new Date(timestamp * 1000);

    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');

    return `
    <td>
        <span class="nowrap">${year}-${month}-${day}</span>
        <span class="nowrap">${hours}:${minutes}:${seconds}</span>
    </td>
    `;
}

function updateTable(orders) {
    let ordersTable = $('#orders-table tbody');
    ordersTable.empty();

    $.each(orders, function(index, order) {
        const orderDate = parseDate(order.created_at);
        ordersTable.append(`
            <tr>
                <td>${order.id}</td>
                <td>${order.user.first_name} ${order.user.last_name}</td>
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
}

function fetchAndUpdateServices(urlParams) {
    const status = urlParams.get('status');
    const mode = urlParams.get('mode');
    const searchQuery = urlParams.get('search');
    const searchType = urlParams.get('search-type');

    const requestData = {};
    if(status) requestData.status = status;
    if(mode) requestData.mode = mode;
    if(searchQuery) requestData.search = searchQuery;
    if(searchType) requestData['search-type'] = searchType;

    $.ajax({
        url: '/api/services',
        method: 'GET',
        data: requestData,
        dataType: 'json',
        success: function(data) {
            updateServicesFilter(data)
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Ошибка при загрузке данных: ', textStatus, errorThrown);
        }
    });
}

function updateServicesFilter(servicesData) {
    const urlParams = new URLSearchParams(window.location.search);
    let serviceList = $('#services-data');
    serviceList.empty();

    const selectedService = Number(urlParams.get('service_id'));

    serviceList.append(`<li class="${!selectedService ? 'active' : ''}"><a href="">All (${servicesData.totalCount})</a></li>`);

    $.each(servicesData.services, function(index, service) {
        serviceList.append(`
            <li data-id="${service.id}" class="${selectedService === service.id ? 'active' : ''}">
                <a href=""><span class="label-id">${service.order_count}</span>  ${service.name}</a>
            </li>
        `);
    });

    $('#services-data li').on('click', function() {
        const selectedService = $(this).data('id');

        if (selectedService) {
            urlParams.set('service_id', selectedService);
        } else {
            urlParams.delete('service_id');
        }

        const newUrl = window.location.pathname + '?' + urlParams.toString();
        window.history.pushState({ path: newUrl }, '', newUrl);

        $('#services-data li').removeClass('active');
        $(this).addClass('active');

        fetchOrdersAndUpdateTable(urlParams);
        fetchAndUpdateServices(urlParams);

        return false;
    });
}
