import './bootstrap';

import $ from 'jquery';

// Core DataTables
import 'datatables.net';

// Correct CSS path
import 'datatables.net-dt/css/dataTables.dataTables.css';

// Optional: Tailwind custom CSS (if you downloaded it to resources/css)
// import '../css/dataTables.tailwindcss.css';

window.$ = window.jQuery = $;

$(function () {
    $('#items-table').DataTable({
        pageLength: 10,
        lengthChange: false,
        searching: true,
        responsive: true,
        language: {
            search: "",
            searchPlaceholder: "Search items..."
        },
        initComplete: function () {
            // Search box styling
            $('#items-table_filter input')
                .addClass('border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none')
                .css('width', '250px');

            // Position search bar
            $('#items-table_filter').addClass('mb-4 float-left');

            // Pagination styling
            $('.dataTables_paginate').addClass('flex justify-end mt-4');
            $('.dataTables_paginate a')
                .addClass('px-3 py-1 border border-gray-300 rounded mx-1 text-gray-700 hover:bg-green-500 hover:text-white transition');
        }
    });
});
$(function () {
    $('#inventory-table').DataTable({
        pageLength: 10,
        lengthChange: false,
        searching: true,
        responsive: true,
        language: {
            search: "",
            searchPlaceholder: "Search items..."
        },
        createdRow: function (row, data, dataIndex) {
            // Apply smaller font + ellipsis for table body cells
            $('td', row).each(function () {
                $(this).css({
                    'font-size': '0.85rem',
                    'max-width': '150px',
                    'white-space': 'nowrap',
                    'overflow': 'hidden',
                    'text-overflow': 'ellipsis'
                });
            });
        },
        headerCallback: function (thead, data, start, end, display) {
            // Make header smaller with green background
            $(thead).find('th').css({
                'font-size': '0.85rem',
                'background-color': '#00c950',
                'color': 'white',
                'border-bottom': '2px solid #e5e7eb',
                'white-space': 'nowrap',
                'overflow': 'hidden',
                'text-overflow': 'ellipsis',
                'padding': '8px'
            });
        },
        initComplete: function () {
            // Apply rounded borders to table
            $('#inventory-table').css({
                'border-collapse': 'separate',
                'border-spacing': '0',
                'border': '1px solid #e5e7eb',
                'border-radius': '10px',
                'overflow': 'hidden',
                'width': '100%'
            });

            // Round header top corners
            $('#inventory-table thead th:first-child').css({
                'border-top-left-radius': '10px'
            });
            $('#inventory-table thead th:last-child').css({
                'border-top-right-radius': '10px'
            });

            // Round bottom corners on last row
            $('#inventory-table tbody tr:last-child td:first-child').css({
                'border-bottom-left-radius': '10px'
            });
            $('#inventory-table tbody tr:last-child td:last-child').css({
                'border-bottom-right-radius': '10px'
            });

            // Search box styling
            $('#inventory-table_filter input')
                .addClass('border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none')
                .css('width', '250px');

            // Position search bar
            $('#inventory-table_filter').addClass('mb-4 float-left');

            // Pagination styling
            $('.dataTables_paginate').addClass('flex justify-end mt-4');
            $('.dataTables_paginate a')
                .addClass('px-3 py-1 border border-gray-300 rounded mx-1 text-gray-700 hover:bg-green-500 hover:text-white transition');
        }
    });
});
