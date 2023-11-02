<template>
    <div class="page-wrapper">
        <div>


            <h2>الحضور والغياب</h2>
        </div>
        <div class="content container-fluid">



            <!-- Search Filter -->
            <div class="row filter-row">


                <div class="col-sm-6 col-md-3">

                    <label class="focus-label">الموظف</label>
                    <select @change="select_staff" v-model="staff_selected" name="type" id="type"
                        class="select floating form-control " required>
                        <option>-</option>
                        <option v-for="staff in staffs" v-bind:value="staff.id">
                            {{ staff.name }}
                        </option>
                    </select>

                </div>


                <div class="col-sm-6 col-md-3">
                    <label class="focus-label">الشهر</label>

                    <select v-model="month_selected" class="select floating form-control">
                        <option>-</option>
                        <option v-bind:value="1">Jan</option>
                        <option v-bind:value="2">Feb</option>
                        <option v-bind:value="3">Mar</option>
                        <option v-bind:value="4">Apr</option>
                        <option v-bind:value="5">May</option>
                        <option v-bind:value="6">Jun</option>
                        <option v-bind:value="7">Jul</option>
                        <option v-bind:value="8">Aug</option>
                        <option v-bind:value="9">Sep</option>
                        <option v-bind:value="10">Oct</option>
                        <option v-bind:value="11">Nov</option>
                        <option v-bind:value="12">Dec</option>
                    </select>

                </div>
                <div class="col-sm-6 col-md-3">
                    <label class="focus-label">السنه</label>
                    <select v-model="year_selected" class="select floating form-control">
                        <option>-</option>
                        <option v-bind:value="9">2023</option>
                        <option v-bind:value="8">2022</option>
                        <option v-bind:value="7">2021</option>
                        <option v-bind:value="6">2020</option>
                        <option v-bind:value="5">2019</option>
                        <option v-bind:value="4">2018</option>
                        <option v-bind:value="3">2017</option>
                        <option v-bind:value="2">2016</option>
                        <option v-bind:value="1">2015</option>
                    </select>

                </div>
                <div class="col-sm-6 col-md-3" style="margin-top: auto;">
                    <a href="#" @click="search()"><img src="/assets/img/search.png" alt="" style="width: 10%;"> </a>
                </div>


            </div>
            <hr>
            <hr>
            <!-- /Search Filter -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table table-nowrap mb-0">
                            <thead>
                                <tr id="name_day">

                                </tr>
                            </thead>
                            <tbody>

                                <!-- <tr id="body_day" >
                                  



                                </tr> -->

                                <tr id="body_day" v-for="(attendance, index) in list_data.data" :key="index">

                                    <td>


                                        <div>
                                            <a class="btn btn-link" href="javascript:void(0);" data-toggle="modal"
                                                data-target="#attendance_info"> {{ attendance.name }}
                                            </a>
                                        </div>


                                    </td>





                                    <td v-for="(atten, index1) in date_compare" :key="index1">

                                        <template v-for="attends in attendance.attendance">

                                            <div v-if="attends.attendance_date == atten">

                                                <a class="btn btn-info" v-if="attends.attendance_final == 'complete'"
                                                    href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#attendance_info">حاضر
                                                </a>

                                                <a v-else class="btn btn-danger" href="javascript:void(0);"
                                                    data-toggle="modal" data-target="#attendance_info">A
                                                </a>



                                            </div>



                                        </template>
                                        <div v-for="attends_fri in full_day_name">
                                            <a v-if="attends_fri == atten" class="btn btn-danger" href="javascript:void(0);"
                                                data-toggle="modal" data-target="#attendance_info">عطله نهايه الاسبوع
                                            </a>
                                        </div>

                                        <div v-for="holiday in official_holidays">

                                            <div v-if="holiday.code == 1">
                                                <a v-if="holiday.from_date == atten" class="btn btn-secondary"
                                                    href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#attendance_info">عيد الفطر
                                                </a>

                                            </div>


                                            <div v-if="holiday.code == 2">
                                                <a v-if="holiday.from_date == atten" class="btn btn-warning"
                                                    href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#attendance_info">عيد الاضحي
                                                </a>
                                            </div>

                                            <div v-if="holiday.code == 3">
                                                <a v-if="holiday.from_date == atten" class="btn btn-success"
                                                    href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#attendance_info">عيد 22 مايو
                                                </a>
                                            </div>


                                            <div v-if="holiday.code == 4">
                                                <a v-if="holiday.from_date == atten" class="btn btn-primary"
                                                    href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#attendance_info">عيد 14 اكتوبر
                                                </a>
                                            </div>

                                            <div v-if="holiday.code == 5">
                                                <a v-if="holiday.from_date == atten" class="btn btn-light"
                                                    href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#attendance_info">عيد 30 نوفمبر
                                                </a>
                                            </div>

                                            <div v-if="holiday.code == 6">
                                                <a v-if="holiday.from_date == atten" class="btn btn-link"
                                                    href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#attendance_info">عيد 26 سبتمبر
                                                </a>
                                            </div>



                                        </div>






                                    </td>







                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <pagination align="center" :data="list_data" @pagination-change-page="list"></pagination>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../../js/staff/StaffData/staff_data.js';

export default {
    components: {
        pagination,
    },
    mixins: [operation],
    data() {
        return {
            // category: "yes",

            list_data: {
                type: Object,
                default: null,
            },

            official_holidays: '',
            count: '',
            date_compare: [],
            full_day_name: [],
            staff_selected: 1,
            start_date: "",
            end_date: "",
            days: 2,
            name: "",
            table: 'attendance',
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

        search() {

    
        },
        append_head(html_head, i, full_day_name, date) {


            if (full_day_name == 'Fri') {
                this.full_day_name[i - 1] = date;
                html_head = html_head + `<th>
                                                <span>${i}</span> <hr> 
                                                <span style='color:red'>${full_day_name}</span>
                                                     
                                            </th>`
            } else {
                html_head = html_head + `<th>
                                                <span>${i}</span> <hr> 
                                                <span>${full_day_name}</span>
                                                     
                                            </th>`
            }

            return html_head;

        },
        append_body(html_body, i, data) {

            html_body = html_body + `<td>
                                            <span style='color:red'>${data}</span>
                                                     
                                    </td>`


            return html_body;



        },
        convert_date(year, month, i) {


            if (i < 10) {

                this.date_compare[i - 1] = `${year}-0${month}-0${i}`

            } else {
                this.date_compare[i - 1] = `${year}-0${month}-${i}`

            }

        },
        get_day_name(data) {

            var date_obj = new Date();
            var month = 6
            // alert(month);
            var year = date_obj.getFullYear();

            var html_head = `<th>الموظف</th>`;
            var html_body = ``;
            this.count = new Date(year, month, 0).getDate();
            
          

            for (var i = 1; i <= this.count; i++) {


                const date_str = `${month}/${i}/${year}`
                const date = new Date(date_str);
                const full_day_name = date.toLocaleDateString('default', { weekday: 'short' });

                this.convert_date(year, month, i);
                html_head = this.append_head(html_head, i, full_day_name, this.date_compare[i - 1]);
                html_body = this.append_body(html_body, i, data);

           

            }
          
            $(`#name_day`).html(html_head);



        },
        list(page = 1) {

            this.axios
                .post(`/attendance?page=${page}`)
                .then(({ data }) => {
                    // var split_start = data.list.start_time[index].split(":");

                    console.log('attendance', data.list.data[0].attendance[0])

                    this.list_data = data.list;
                    this.official_holidays = data.official_holidays;

                    this.staffs = data.staffs;

                })
                .catch(({ response }) => {
                    console.error(response);
                });

            console.log('muhibbbbbbbbbb', this.list_data);
            this.get_day_name(this.list_data.data);

        },

    },
};
</script>

