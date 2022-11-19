<template>
<div class="row">
	<h6 class="card-title">PERMISOS</h6>
</div>
<div class="row"> 
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover mb-0">
						<thead>
						<tr>
							<th class="pt-0">#</th>
							<th class="pt-0">Nombre</th>
							<th class="pt-0">Descripción</th>
						</tr>
						</thead>
						<tbody>
							<tr v-for="(row, index) in records" :key="row">
								<td>{{ index + 1}}</td>
								<td>{{ row.name }}</td>
								<td>{{ row.description}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</template>

<script>
	import axios from "axios"

    export default {
		data(){
			return {
                resource: 'permissions',
                records: [],
            }
		},
		created() {
            this.getData()
        },
        methods: {
            getData() {
                axios.get(`/${this.resource}/records`)
                    .then(response => {
                        this.records = response.data.data
                    })
            }
        }
    }
</script>
