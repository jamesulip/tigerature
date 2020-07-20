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



        <h2 class="h4">Temperature Record</h2>

        <b-overlay :show="loading" rounded="sm">
          <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm table-fontsmall">
                  <thead>
                      <tr>
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
                      <template v-for="(item) in logs">
                            <tr v-for="(item2, id) in item.logs" :key="`id${item2.id}`">

                                <td>{{item.employee_id}}</td>
                                <td>{{item.last_name}},{{item.first_name}}</td>
                                <td>{{item2.created_at | formatDate('YY-M-D')}}</td>
                                <td>{{item2.created_at | formatDate('ddd')}}</td>
                                <td>{{item2.created_at | formatDate('hh:m a')}}</td>
                                <td :class="tempColor(item2.temp)">{{item2.temp}}°</td>
                                <td>
                                    <template v-if="item2.log">
                                            <span class="badge bg-danger" v-for="(item, index) in item2.log.answer" :key="index">
                                              {{item}}
                                        </span>
                                    </template>


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
export default {
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
