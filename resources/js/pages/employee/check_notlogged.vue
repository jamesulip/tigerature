<template>
    <div>

        <b-button class="mb-3" @click="resultsModal = true">Check Not Logged</b-button>


        <b-modal v-model="resultsModal" title="BootstrapVue">
            <p class="my-4">Filter Not logged</p>
             <textarea @input="Test()" class="form-control" name="" v-model="list" id="" cols="30" rows="10"></textarea>
             <b-table striped hover :items="notLogged"></b-table>
        </b-modal>

    </div>
</template>

<script>
export default {
    props:['employees'],

    data() {
        return {
            notLogged:[],
            resultsModal:false,
            list:null
        }
    },
    methods: {
        Test(){
           var logged = (this.list.split('\n').filter(Boolean))
           var ww = this.employees.filter(x=>{
               return _.includes(logged, x.employee_id.toString());
           }).filter(x=>{
               return !x.logs.length
           }).map(x=>{
               return {
                   Employee_id:x.employee_id,
                   First_Name:x.first_name,
                   Last_name:x.last_name,
               }
           })
            this.notLogged = ww;

            this.resultsModal = true
        }
    },
}
</script>
