<template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">

    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group mr-2">
        <!-- <button class="btn btn-sm btn-outline-secondary">Add Employee</button> -->
        <addemployee @added="getEmployees()"/>
        <!-- <button class="btn btn-sm btn-outline-secondary">Export</button> -->
      </div>
      <!-- <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
        <span data-feather="calendar"></span>
        This week
      </button> -->
    </div>
  </div>



  <h2 class="h4">Employee List</h2>
  <div class="table-responsive">
    <table class="table table-striped table-valign-middle">
      <thead>
        <tr>
          <th>ID Number</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Address</th>
          <!-- <th>Last Temperature</th> -->
          <th colspan="2" style="width:1%">Action</th>
          <!-- <th style="width:1%"></th> -->
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in employees.data" :key="index">
            <td>{{item.employee_id}}</td>
            <td>{{item.first_name}}</td>
            <td>{{item.last_name}}</td>
            <td>{{item.address}}</td>
            <!-- <td>{{item.created_at | formatDate('LL')}}</td> -->
            <td style="diplay:flex">
                <a class="text-red" role="button"  @click="deleteEmp(item)"><i class="fa fa-trash"></i></a>


            </td><td style="diplay:flex">
                <!-- <a class="text-info" role="button"  @click="deleteEmp(item)"><i class="fa fa-edit"></i></a> -->
                <edit_emp v-model="employees.data[index]"/>


            </td>
        </tr>
      </tbody>
    </table>
  </div>
    </div>
</template>

<script>
import addemployee from './employee/add'
import edit_emp from './employee/edit'
import moment from 'moment'
export default {
    components:{
        addemployee,edit_emp
    },
    data() {
        return {
            employees:[]
        }
    },
    filters:{
        formatDate(value,format){
            return moment(value).format(format)
        }
    },
    mounted() {
        this.getEmployees();
    },
    methods: {
        deleteEmp(user){
            this.$bvModal.msgBoxConfirm(`Are you sure you want to delete ${user.last_name},${user.first_name}?`, {
                title: 'Please Confirm',
                size: 'sm',
                buttonSize: 'sm',
                okVariant: 'danger',
                okTitle: 'YES',
                cancelTitle: 'NO',
                footerClass: 'p-2',
                hideHeaderClose: false,
                centered: true
            })
            .then(value => {
               if(value){
                    axios.delete(`/api/employees/${user.id}`)
                    .then(res => {
                        this.getEmployees()
                    })
                    .catch(err => {
                        console.error(err);
                    })
               }
            })
            .catch(err => {
            })
        },
        getEmployees(){
            this.loading = true;
            axios.get(`/api/employees`)
            .then(res => {
                this.employees = res.data
               this.loading = false;
            })
            .catch(err => {
                console.error(err);
                this.loading = false;
            })
        }
    },
}
</script>
