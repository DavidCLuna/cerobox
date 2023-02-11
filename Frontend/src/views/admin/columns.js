const tableDataColumns = {
    "services": [
        {
            text: 'Nombre',
            sortable: false,
            value: 'name',
        },
        {
            text: 'Tipo',
            value: 'type'
        },
        {
            text: 'Fecha de Inicio',
            value: 'start_date'
        },
        {
            text: 'Fecha Final',
            value: 'end_date'
        },
    ],
    "clients": [
        {
            text: 'Nombre',
            sortable: false,
            value: 'name',
        },
        {
            text: 'Email',
            value: 'email'
        },
        {
            text: 'Teléfono',
            value: 'phone'
        },
        {
            text: 'Documento',
            value: 'document'
        },
        {
            text: 'Observaciones',
            value: 'observations'
        },
    ],
    "service_clients": [
        {
            text: 'Nombre del Cliente',
            sortable: false,
            value: 'client.name',
        },
        {
            text: 'Email del Cliente',
            value: 'client.email'
        },
        {
            text: 'Nombre del Servicio',
            value: 'service.name'
        },
        {
            text: 'Tipo del Servicio',
            value: 'service.type'
        },
        {
            text: 'Fecha de Inicio',
            value: 'service.start_date'
        },
        {
            text: 'Fecha Final',
            value: 'service.end_date'
        },
    ]
}

export default tableDataColumns