<template>

    <div class="page-wrapper">
        <div class="content container-fluid">



            <!-- Search Filter -->
            <div class="row filter-row">
                <!-- <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating">
                            <label class="focus-label">Employee Name</label>
                        </div>
                    </div> -->

                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <label class="focus-label">Employee Name</label>
                        <input type="text" class="form-control floating">

                    </div>
                </div>


                <!-- <div class="col-md-2">
                    <label for="status">اسم الموظف</label>
                    <select v-model="staffselected" name="type" id="type" class="form-control " required>
                        <option v-for="staff in staffs" v-bind:value="staff.id">
                            {{ staff.name }}
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="status">اسم الموظف</label>
                    <select v-model="staffselected" name="type" id="type" class="form-control " required>
                        <option v-for="staff in staffs" v-bind:value="staff.id">
                            {{ staff.name }}
                        </option>
                    </select>
                </div> -->

                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating">
                            <option>-</option>
                            <option>Jan</option>
                            <option>Feb</option>
                            <option>Mar</option>
                            <option>Apr</option>
                            <option>May</option>
                            <option>Jun</option>
                            <option>Jul</option>
                            <option>Aug</option>
                            <option>Sep</option>
                            <option>Oct</option>
                            <option>Nov</option>
                            <option>Dec</option>
                        </select>
                        <label class="focus-label">Select Month</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating">
                            <option>-</option>
                            <option>2019</option>
                            <option>2018</option>
                            <option>2017</option>
                            <option>2016</option>
                            <option>2015</option>
                        </select>
                        <label class="focus-label">Select Year</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <a href="#" class="btn btn-success btn-block"> Search </a>
                </div>
            </div>
            <!-- /Search Filter -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>5</th>
                                    <th>6</th>
                                    <th>7</th>
                                    <th>8</th>
                                    <th>9</th>
                                    <th>10</th>
                                    <th>11</th>
                                    <th>12</th>
                                    <th>13</th>
                                    <th>14</th>
                                    <th>15</th>
                                    <th>16</th>
                                    <th>17</th>
                                    <th>18</th>
                                    <th>19</th>
                                    <th>20</th>
                                    <th>22</th>
                                    <th>23</th>
                                    <th>24</th>
                                    <th>25</th>
                                    <th>26</th>
                                    <th>27</th>
                                    <th>28</th>
                                    <th>29</th>
                                    <th>30</th>
                                    <th>31</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(attendance, index) in attendances.data" :key="index">
                                    <td>
                                        <h5 class="table-avatar">
                                            <a class="avatar avatar-xs" ><img alt=""
                                                    src="assets/img/ecommerce/01.jpg"></a>
                                            <a >{{ attendance.name }}</a>
                                        </h5>
                                    </td>

                                    <td v-for="attends in attendance.attendance">
                                        <a href="javascript:void(0);" data-toggle="modal"
                                            data-target="#attendance_info">{{ attends.attendance_status }}</a>
                                    </td>


                                    <!-- <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td> -->
                                    <!-- <td>
                                           
                                            <a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info">A</a>
                                        </td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><i class="fa fa-close text-danger"></i> </td>
                                        <td><i class="fa fa-close text-danger"></i> </td>
                                        <td><i class="fa fa-close text-danger"></i> </td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><i class="fa fa-close text-danger"></i> </td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td>
                                            <div class="half-day">
                                                <span class="first-off"><i class="fa fa-close text-danger"></i></span>
                                                <span class="first-off"><a href="javascript:void(0);"
                                                        data-toggle="modal" data-target="#attendance_info"><i
                                                            class="fa fa-check text-success"></i></a></span>
                                            </div>
                                        </td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><i class="fa fa-close text-danger"></i> </td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><i class="fa fa-close text-danger"></i> </td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td>
                                        <td><a href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"><i
                                                    class="fa fa-check text-success"></i></a></td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <pagination align="center" :data="attendances" @pagination-change-page="list"></pagination>

                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
import pagination from "laravel-vue-pagination";

export default {
    components: {
        pagination,
    },

    data() {
        return {
            // category: "yes",

            attendances: {
                type: Object,
                default: null,
            },

            staff_selected: 1,
            start_date: "",
            end_date: "",
            days: 2,
            name: "",

            staffs: "",
            jobselected: 1,
            branchselected: 1,
            staff_typeselected: 1,
            vacation_typeselected: 1,
            staffselected: 1,

            staff_on_change: "",
            vactions: "",
            jobs: "",
            branches: "",
            staff_types: "",
            vacation_types: "",
            word_search: "",
        };
    },
    mounted() {
        this.list();
    },
    methods: {


        list(page = 1) {
            this.axios
                .post(`/attendance?page=${page}`)
                .then(({ data }) => {
                    console.log(data.attendance)
                    this.attendances = data.attendances;

                    // this.staffs = data.staffs;
                    // this.jobs = data.jobs;
                    // this.branches = data.branches;
                    // this.staff_types = data.staff_types;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },

    },
};
</script>
  
  