<template>

   <button type="button" @click="showModal=true" class="btn btn-link text-info">
        <i class="fa fa-edit"></i>




        <b-modal v-model="showModal" title="Edit Employee" @ok="handleOk">
            <b-overlay :show="loading" rounded="sm">
                <form ref="form">
                    <b-form-group :state="errors.employee_id" id="input-group-1" label="Employee ID:" label-for="input-1"
                        invalid-feedback="Employee ID is required">
                        <b-form-input id="input-0" v-model="form.employee_id" type="number" required placeholder="Employee ID">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group :state="errors.first_name" id="input-group-1" label="First Name:" label-for="input-1"
                        invalid-feedback="Name is required">
                        <b-form-input id="input-1" v-model="form.first_name" type="email" required placeholder="Enter First Name">
                        </b-form-input>
                    </b-form-group>

                    <b-form-group :state="errors.last_name" id="input-group-1" label="Last Name:" label-for="input-1" invalid-feedback="Last Name is required">

                        <b-form-input id="input-2" v-model="form.last_name" type="text" required placeholder="Enter email">
                        </b-form-input>

                    </b-form-group>

                    <b-form-group :state="errors.address" id="input-group-1" label="Address:" label-for="input-1" invalid-feedback="Name is required"
                        description="Enter you default address so that you will never input again.">

                        <b-form-textarea id="input-3" v-model="form.address" required placeholder="Enter default address">
                        </b-form-textarea>

                    </b-form-group>

                </form>
            </b-overlay>
        </b-modal>



    </button>




</template>
<script>
export default {
    props:['value'],
    data() {
        return {
            form:{
                employee_id:null,
                first_name:null,
                last_name:null
            },
            loading:false,
            showModal:false,
            errors:{}
        }
    },
    mounted() {
        this.form = this.value
    },
    methods: {
        handleOk(bvModalEvt){
            this.loading = true
            this.errors = {}
            bvModalEvt.preventDefault()

            axios.put(`/api/employees/${this.form.id}`,this.form)
            .then(res => {
                this.loading = false
                this.$nextTick(() => {
                    this.showModal = false
                })
                 this.$emit('input',res.data.data)



            })
            .catch(err => {
                this.loading = false
                Object.keys(err.response.data.errors).forEach(x=>{
                    this.errors[x] = false
                })
               return
            })
        }
    },
}
</script>
