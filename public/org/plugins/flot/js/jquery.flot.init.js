if (localStorage.getItem("user_type") == 4) {

    $(function () {
        'use strict';

        var employees;
        var piedataemployees;

        // get total Employees per org
        $.ajax(`../../../../api.php?section=users&do=count_org_employees_managers`, {
            method: `POST`,
            success: function (data, textStatus, jqXHR) {
                if (data == "false") {
                    $('#employees_count').hide();
                } else {
                    var totalEmployees = JSON.parse(data);
                    employees = parseInt(totalEmployees.employees);
                    var managers = parseInt(totalEmployees.managers);
                    var total = managers + employees;

                    var piedataemployees = [{
                        label: "Employees",
                        data: [
                            [total, employees]
                        ],
                        color: '#ff5e5e'
                    },
                    {
                        label: "Managers",
                        data: [
                            [total, managers]
                        ],
                        color: '#7571F9'
                    }];


                    $.plot('#flotPie1', piedataemployees, {
                        series: {
                            pie: {
                                show: true,
                                radius: 1,
                                label: {
                                    show: true,
                                    radius: 2 / 3,
                                    formatter: labelFormatter,
                                    threshold: 0.1
                                }
                            }
                        },
                        grid: {
                            hoverable: true,
                            clickable: true
                        }
                    });

                    $(document).trigger('count_serv_employees', [employees]);
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });


        $(document).on('count_serv_employees', function (e, employees) {
            // get total Pending Employees per org
            $.ajax(`../../../../api.php?section=service_employee&do=count_org_serv_employees`, {
                method: `POST`,
                success: function (data, textStatus, jqXHR) {
                    if (data == "false") {
                        $('#employees_in_service').hide();
                    } else {
                        var servingEmp = JSON.parse(data);
                        var serving = parseInt(servingEmp.total_serv_emp);
                        var notServing = employees - serving;

                        piedataemployees = [{
                            label: "Not Serving",
                            data: [
                                [employees, notServing]
                            ],
                            color: '#ff5e5e'
                        },
                        {
                            label: "Serving",
                            data: [
                                [employees, serving]
                            ],
                            color: '#7571F9'
                        }
                        ];

                        $.plot('#flotPie2', piedataemployees, {
                            series: {
                                pie: {
                                    show: true,
                                    radius: 1,
                                    innerRadius: 0.5,
                                    label: {
                                        show: true,
                                        radius: 5 / 8,
                                        formatter: labelFormatter,
                                        threshold: 0.1
                                    }
                                }
                            },
                            grid: {
                                hoverable: true,
                                clickable: true
                            }
                        });
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        })

        function labelFormatter(label, series) {
            return "<div style='font-size:9pt; text-align:center; padding:3px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
        }

    });


}