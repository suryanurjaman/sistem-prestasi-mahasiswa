@props([
    'profit' => '0', // e.g. "5,405"
    'profitRate' => '0%', // e.g. "23.5%"
    'income' => '0', // e.g. "23,635"
    'expense' => '0', // e.g. "18,230"
    'categories' => [], // e.g. ['Jul','Aug',...]
    'incomeData' => [], // e.g. [1420,1620,...]
    'expenseData' => [], // e.g. [788,810,...]
    'chartId' => 'bar-chart', // unique ID
    'linkUrl' => '#', // URL for “Revenue Report”
])

<div {{ $attributes->merge(['class' => 'w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6']) }}>
    {{-- Header --}}
    <div class="flex justify-between border-b border-gray-200 dark:border-gray-700 pb-3">
        <dl>
            <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Prestasi Pertahun</dt>
        </dl>
    </div>

    {{-- Chart container, data disimpan di data-attributes --}}
    <div id="{{ $chartId }}" data-categories='@json($categories)' data-income='@json($incomeData)'
        data-expense='@json($expenseData)'></div>

</div>

@once
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // inisialisasi dropdown dari Flowbite (jika dipakai)
                if (typeof Flowbite !== 'undefined') {
                    window.Dropdown && document.querySelectorAll('[data-dropdown-toggle]').forEach(btn => {
                        Dropdown.init(btn);
                    });
                }

                // render semua chart-card yang ada di halaman
                document.querySelectorAll('[id^="{{ $chartId }}"]').forEach(el => {
                    const categories = JSON.parse(el.dataset.categories);
                    const income = JSON.parse(el.dataset.income);
                    const expense = JSON.parse(el.dataset.expense);

                    const options = {
                        series: [{
                                name: "Income",
                                data: income,
                                color: "#31C48D"
                            },
                            {
                                name: "Expense",
                                data: expense,
                                color: "#F05252"
                            }
                        ],
                        chart: {
                            type: "bar",
                            width: "100%",
                            height: 400,
                            toolbar: {
                                show: false
                            },
                            sparkline: {
                                enabled: false
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: true,
                                columnWidth: "100%",
                                borderRadius: 6,
                                dataLabels: {
                                    position: "top"
                                }
                            }
                        },
                        legend: {
                            show: true,
                            position: "bottom"
                        },
                        dataLabels: {
                            enabled: false
                        },
                        tooltip: {
                            shared: true,
                            intersect: false,
                            y: {
                                formatter: v => "$" + v
                            }
                        },
                        xaxis: {
                            categories: categories,
                            labels: {
                                formatter: v => "$" + v,
                                style: {
                                    fontFamily: "Inter, sans-serif",
                                    fontSize: "12px"
                                }
                            },
                            axisTicks: {
                                show: false
                            },
                            axisBorder: {
                                show: false
                            }
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    fontFamily: "Inter, sans-serif",
                                    fontSize: "12px"
                                }
                            }
                        },
                        grid: {
                            show: true,
                            strokeDashArray: 4,
                            padding: {
                                left: 2,
                                right: 2,
                                top: -20
                            }
                        },
                        fill: {
                            opacity: 1
                        }
                    };

                    new ApexCharts(el, options).render();
                });
            });
        </script>
    @endpush
@endonce
