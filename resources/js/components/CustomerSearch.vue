<template>
    <div :class="! width ? 'col-xl-3 col-12' : classes ">

        <div class="form-group">
            <label class="control-label" :class="width && ! classes ? 'text-white': ''" v-if="showLabel">
                Cliente
                <a href="#" class="text-info font-weight-bold m-0 p-0" @click.prevent="newPerson">[+ Nuevo]</a>

                <small class="text-success font-weight-bold m-0 p-0"
                       v-if="customerSelect && Object.keys(customerSelect).length > 0 "></small>
            </label>
            <el-select v-model="customer" name="customer" filterable remote clearable @change="changeCustomer"
                       placeholder="Búsqueda de cliente, ingrese el término a buscar" id="select-width" :remote-method="loadItems">
                <el-option v-for="option in persons" :key="option.id" :value="option.id" :label="option.description"></el-option>
            </el-select>
            <small class="form-control-feedback" v-if="errors.customer_id" v-text="errors.customer_id[0]"></small>
        </div>


        <!-- <person-form v-if="showDialogNewPerson"
		            typecustomer="customers"
                    :document_type_id="document_type_id"
                    :recordId="customer" @saveAppt="saveAppt"></person-form> -->
		
    </div>
	<person-form type="customers" :recordId="customer" @closeModal="closeModal" v-if="showModal"/>

</template>

<script>
import PersonForm from '../views/Persons/Customer.vue'

export default {
    props: ['type', 'customer_id', 'customersList','disabled', 'width',
        'classes', 'name', 'errors', 'showLabel'],

    components: {PersonForm},
    data() {
        return {
            resource: 'persons',
            persons: [],
            personsBack: [],
            showModal: false,
            customer: this.customer_id,
            customerSelect: {}
        }

    },
    async created() {
		
        this.personsBack = this.customersList ? this.customersList : [];
        this.persons = this.customersList ? this.customersList : [];
        
		this.emitter.on('reloadDataCustomers',(customer_id)=>{
			this.reloadDataCustomers(customer_id)
		});

        if (this.customer_id) {
            let newCustomer = await this.loadCustomer(this.customer_id);
            this.addNewCustomer(newCustomer);
            this.filterCustomers();

            this.customer = +this.customer_id;
        }
    },
    methods: {
        loadItems(query) {
            if (query && query.length > 2) {
                axios.post(`/search/${this.resource}/customers`, {search: query})
                    .then(({data}) => {
						
                        this.persons = data;

                        this.filterCustomers();
                    });
            } else {
                this.persons = this.personsBack;
            }
        },
        changeCustomer() {
            this.emitter.emit('update:customer_id', this.customer)
            let per = this.persons.find(el => el.id == this.customer);
            this.customerSelect = per;
        },
        async reloadDataCustomers(customer_id) {
            let newCustomer = await this.loadCustomer(customer_id);

            this.addNewCustomer(newCustomer);
            this.customer = +customer_id;
            this.changeCustomer();
        },
        async loadCustomer(id) {
            let {data} = await axios.get(`/${this.resource}/record/${id}`);
            let newCustomer = data.data;
            return newCustomer
        },
        addNewCustomer(newCustomer) {
            if (newCustomer) {
                let indexSearch = this.persons.findIndex(el => el.id == newCustomer.id);
                if (indexSearch == -1) {
                    this.persons.push(newCustomer);
                    let indexSearch2 = this.personsBack.findIndex(el => el.id == newCustomer.id);
                    if (indexSearch2 == -1) {
                        this.personsBack.push(newCustomer);
                    }
                }
            }
        },
        filterCustomers() {
            if (this.persons.length == 0) {
                this.persons = this.personsBack
            }
			if (this.persons.length > 0) {
				this.setCustomerDefault();
			}
        },
        setCustomerDefault() {
            let per = null;
            if (this.customer_id) {
                per = this.persons.find(el => el.id == this.customer_id);
            } else if (this.customer) {
                per = this.persons.find(el => el.id == this.customer);
            } else {
                per = this.persons.find(el => el.id == 1);
            }
            if (per) this.customer = per.id;
        },
        newPerson() {
            this.customer = null;
            this.showModal = true;
        },
		closeModal(){
			this.showModal = false
			// this.initForm()
		}
    },
    watch: {
        'document_type_id': function () {
            this.changeCustomer();
        },
        'customersList': function () {
			
            this.personsBack = this.customersList ? this.customersList : [];
            this.persons = this.customersList ? this.customersList : [];
            this.filterCustomers();
        }
    }
}
</script>