<template>
<div class="card w-100" :id="'stat'+uniqueid" :data-accordion-target="'#accordion-body-'+uniqueid">
  <div class="card-header">
    {{title}}
  </div>
  <ul class="list-group list-group-flush" :id="'accordion-body-'+uniqueid">
    <li class="list-group-item" v-for="(stat, index) in listData" :key="index">
		<i :class="stat.icon + ' float-left'"></i> <i>{{stat.name}}</i>
	</li>
  </ul>
</div>
</template>
<script>

import {globalMixin} from './../../../mixins/globalmixin'
export default {
	mixins:[globalMixin],
	props: {
		uniqueid: {
			type: String,
			required: true
		},
		title: {
			type: String,
			required: true
		},
		rawlistdata: {
			required: true
		}
	},
	data(){
		return {
			listData: []
		}
	},
	methods:{
		processData(data){
			console.log('PROCESS DATA');
			const vm = this;
			if (Array.isArray(data)) {
				for (let i = 0; i < data.length; i++) {
					const parsed_data = this.returnJSON(data[i]);
					
					if (parsed_data) {
						vm.listData.push(parsed_data);
					}else{
						console.log('data not parsed. Processing failed');
					}
				}
			}			
		}
	},
	mounted(){
		this.processData(this.rawlistdata);
	}
}
</script>
<style lang="scss">

</style>


