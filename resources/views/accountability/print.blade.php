<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1100">
    <title>Print Accountability</title>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* A4 LANDSCAPE PAGE SETTINGS */
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #a4-page,
            #a4-page * {
                visibility: visible;
            }

            #a4-page {
                position: absolute;
                left: 0;
                top: 0;
                margin: 0 auto;
                width: 297mm;
                height: 210mm;
                transform: none;
                box-shadow: none;
                border: none;
            }

            html,
            body {
                width: 297mm;
                height: 210mm;
                margin: 0;
                padding: 0;
            }

            button {
                display: none !important;
            }
        }
    </style>
</head>

<body class="flex flex-col items-center justify-center font-sans m-0 p-5 bg-gray-100">

    <!-- A4 LANDSCAPE PAGE -->
    <div id="a4-page"
        class="bg-white border border-gray-400 shadow-md w-[297mm] h-[210mm] p-[10mm] flex flex-col items-center text-center">

        <!-- Printable Content -->
        <div id="print-area" class="w-full text-[13px]">
            <h1 class="font-bold text-green-600 text-[32px] font-[verdana]">DESCO</h1>
            <p class="font-bold pb-0 m-0">MAIN/PLANT OFFICE</p>
            <p class="leading-tight">
                Lot 2 Block 3 Interstar Street, <br>
                Laguna International Industrial Park, Brgy. Mamplasan, Biñan City, Laguna 4024 <br>
                Tel. Nos. (+632) 8584-4558 to 61 | TeleFax No. (+632) 584-4829 | Email: desco@desco.ph
            </p>

            <h2 class="font-bold text-[22px] underline mt-4 mb-8">I.T. ACCOUNTABILITY LOGSHEET</h2>

            <table class="w-full border border-black border-collapse mt-3 text-[10px] table-fixed">
                <colgroup>
                    <col class="w-[18%]"> <!-- smaller header -->
                    <col class="w-[32%]"> <!-- wider value -->
                    <col class="w-[18%]"> <!-- smaller header -->
                    <col class="w-[32%]"> <!-- wider value -->
                </colgroup>
                <tbody>
                    <tr>
                        <td class="border border-black px-1 py-0.5 font-medium text-left bg-gray-100">Model Name</td>
                        <td class="border border-black px-1 py-0.5 text-left">{{ str($inventory->model_name ?? '')->upper() }}</td>
                        <td class="border border-black px-1 py-0.5 font-medium text-left bg-gray-100">Serial Number</td>
                        <td class="border border-black px-1 py-0.5 text-left">{{ $inventory->serial ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="border border-black px-1 py-0.5 font-medium text-left bg-gray-100">Item Control No
                        </td>
                        <td class="border border-black px-1 py-0.5 text-left" colspan="3">{{ str($inventory->control_no ?? '')->upper() }}</td>
                    </tr>
                    <tr>
                        <td class="border border-black px-1 py-0.5 font-medium text-left bg-gray-100">Remarks</td>
                        <td class="border border-black px-1 py-0.5 text-left" colspan="3">
                            {{ str($inventory->remarks ?? '')->upper() }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="w-full border border-black border-collapse mt-6 text-sm table-fixed">
                <colgroup>
                    <!-- Left half -->
                    <col class="w-[12%]"> <!-- Date Issued -->
                    <col class="w-[22%]"> <!-- Name -->
                    <col class="w-[16%]"> <!-- Signature -->
                    <!-- Right half -->
                    <col class="w-[12%]"> <!-- Date Returned -->
                    <col class="w-[22%]"> <!-- Received by -->
                    <col class="w-[16%]"> <!-- Signature -->
                </colgroup>

                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-black px-2 py-[5px] font-semibold text-[13px]">Date Issued</th>
                        <th class="border border-black px-2 py-[5px] font-semibold text-[13px]">Name</th>
                        <th class="border border-black px-2 py-[5px] font-semibold text-[13px]">Signature</th>
                        <th class="border border-black px-2 py-[5px] font-semibold text-[13px]">Date Returned</th>
                        <th class="border border-black px-2 py-[5px] font-semibold text-[13px]">Received by</th>
                        <th class="border border-black px-2 py-[5px] font-semibold text-[13px]">Signature</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($accountabilities as $a)
                    <tr>
                        <td class="border border-black px-2 py-[4px] text-[12px] text-center">{{ $a->date_received }}</td>
                        <td class="border border-black px-2 py-[4px] text-[12px] font-medium text-left">{{ $a->name }} </td>
                        <td class="border border-black px-2 py-[4px] text-[12px] text-left">✔</td>

                        <td class="border border-black px-2 py-[4px] text-[12px] text-left">{{ $a->date_returned ?? '' }}</td>
                        <td class="border border-black px-2 py-[4px] text-[12px] font-medium text-left"></td>
                        <td class="border border-black px-2 py-[4px] text-[12px] text-left"></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center p-3 text-gray-500">No accountabilities found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>



            <div class="flex justify-between w-full mt-12">
                <p class="m-0 text-[13px]"><strong>Prepared by</strong> : {{ $inventory->created_by ?? '' }}</p>

                <p class="m-0 text-[13px]"><strong>Noted by : </strong>________________________________</p>
            </div>
        </div>
    </div>

    <!-- Buttons (hidden when printing) -->
    <div class="flex gap-3 justify-center mt-5 mb-5 print:hidden">
        <a href="{{ route('inventory.edit', ['inventory' => $inventory->id]) }}"
            class="px-6 py-2 bg-gray-600 text-white rounded-md text-[16px] font-semibold shadow-md hover:bg-gray-700 transition">
            Go Back
        </a>
        <button onclick="window.print()"
            class="px-6 py-2 bg-green-600 text-white rounded-md text-[16px] font-semibold shadow-md hover:bg-green-700 transition">
            Print / Save as PDF
        </button>
    </div>

</body>

</html>
