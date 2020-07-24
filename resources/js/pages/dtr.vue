<template>
    <div>
        <div class="d-flex  flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">

            <div class="col-md-3">
                <label for="example-datepicker">From</label>
                <b-form-datepicker size="sm" id="example-datepicker" v-model="filter.start_date" class="mb-2"></b-form-datepicker>
            </div>
            <div class="col-md-3">
                <label for="example-datepicker2">To</label>
                <b-form-datepicker size="sm" id="example-datepicker2" v-model="filter.end_date" class="mb-2"></b-form-datepicker>
            </div>
             <div class="col-md-3">
                <label for="example-datepicker2">Employee</label>
                 <b-form-select v-model="filter.employee_id" :options="employees" size="sm" class="mb-2"/>
            </div>
             <div class="col-md-12">


                <b-button size="sm" @click="filterData()" class="mt-4">Submit</b-button>
                <!-- <b-form-datepicker id="example-datepicker2" v-model="filter.end_date" class="mb-2"></b-form-datepicker> -->
            </div>
        </div>

        <div class="float-right">
            <!-- <b-button type="info" href="http://google.com" target="_blank" size="sm"><i class="fas fa-table"></i> Export</b-button> -->
            <form id="invisible_form" action="/api/export" method="post" target="_blank">
                <input id="new_window_parameter_1" v-model="filterComputed.start_date" name="start_date" type="hidden" value="default">
                <input id="new_window_parameter_1" v-model="filterComputed.end_date"  name="end_date" type="hidden" value="default">

                <b-button type="submit"  size="sm" target="_blank"><span class="fa fa-download"></span> Download</b-button>
            </form>
        </div>

        <legend class="">Temperature Record</legend>
        <label class="text-muted">{{currentLogged.length}} employee logged their temperature.</label>
        <check_notlogged :employees="logs"/>
        <b-overlay :show="loading" rounded="sm">
          <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm table-fontsmall">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>ID Number</th>
                          <th>Employee Name</th>
                          <th>Date</th>
                          <th>Day</th>
                          <th>Time</th>
                          <th style="width:1%">Temp</th>
                          <th style="width:1%">Symptoms</th>
                      </tr>
                  </thead>
                  <tbody>
                      <template v-for="(item,idx) in currentLogged">
                            <tr v-for="(item2, id) in item.logs" :key="`id${item2.id}`">
                                <td>{{idx+1}}</td>
                                <td>{{item.employee_id}}</td>
                                <td>{{item.last_name}}, {{item.first_name}}</td>
                                <td>{{item2.created_at | formatDate('YY-M-D')}}</td>
                                <td>{{item2.created_at | formatDate('ddd')}}</td>
                                <td>{{item2.created_at | formatDate('hh:m a')}}

                                     <a class="text-red" role="button"  @click="deleteEmp(item,item2)"><i class="fa fa-trash"></i></a>
                                </td>
                                <td :class="tempColor(item2.temp)">{{item2.temp}}°</td>
                                <td>
                                    <template v-if="item2.log">
                                            <span class="badge bg-danger" v-for="(item, index) in item2.log.answer" v-if="item.text" :key="index">
                                              {{item.text}}
                                        </span>
                                    </template>
                                    <span v-else class="badge bg-success">
                                        Ok
                                    </span>


                                </td>
                            </tr>
                      </template>

                  </tbody>
              </table>
          </div>
        </b-overlay>
    </div>
</template>
<script>
import moment from 'moment'
import check_notlogged from './employee/check_notlogged'
export default {
    components:{
        check_notlogged
    },
    data() {
        return {
            filter:{
                start_date:new Date(),
                end_date:new Date(),
                employee_id:null
            },
            logs:[],
            employees:[],
            loading:false
        }
    },
    filters:{
        formatDate(value,format){
            return moment(value).format(format)
        }
    },
    computed: {
        filterComputed:  {
            get: function () {
                return {
                    end_date:moment(this.filter.end_date).format('L'),
                    start_date:moment(this.filter.start_date).format('L'),
                    employee_id:this.filter.employee_id
                }
            }
        },
        currentLogged(){
            return this.logs.filter(x=>{
                return x.logs.length
        })
        }
    },
    mounted(){
        axios.get(`/api/employees`)
        .then(res => {
            this.employees = res.data.data.map(x=>{
                return {
                    text:`${x.last_name}, ${x.first_name}`,
                    value:x.employee_id
                }
            })
            this.employees.push({
                value:null,
                text:'All'
            })
        })
        .catch(err => {
            console.error(err);
        })

        this.filterData()
    },
    methods: {
        deleteEmp(user,item2){
            this.$bvModal.msgBoxConfirm(`Are you sure you want to delete  ${user.first_name}'s ${item2.temp} log?`, {
                title: 'Confirm Delete',
                size: 'sm',
                buttonSize: 'sm',
                okVariant: 'danger',
                okTitle: 'Delete',
                cancelTitle: 'Cancel',
                footerClass: 'p-2',
                hideHeaderClose: false,
                centered: true,
                html:true
            })
            .then(value => {
               if(value){
                    axios.delete(`/api/logs/${item2.id}`)
                    .then(res => {
                        this.filterData()
                    })
                    .catch(err => {
                        console.error(err);
                    })
               }
            })
            .catch(err => {
            })
        },
        tempColor(temp){
            if(temp>=37.6)
                return 'bg-danger disabled'
            else
                return 'bg-green disabled'
        },
        filterData(){
            this.loading=true
            axios.post(`/api/allLog`,this.filter)
            .then(res => {
                this.loading=false
                this.logs = res.data
            })
            .catch(err => {
                this.loading=false
                console.error(err);
            })
        }
    },
}
</script>
<style scoped>
    .table-fontsmall{
        font-size: 15px!important;
    }
</style>
