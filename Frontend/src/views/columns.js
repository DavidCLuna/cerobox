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
            value: 'name',
        },
        {
            text: 'Email del Cliente',
            value: 'email'
        },
        {
            text: 'Teléfono del Cliente',
            value: 'phone'
        },
        {
            text: 'Nombres de los Servicios',
            value: 'services_names'
        },
        
    ]
}

export default tableDataColumns