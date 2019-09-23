<template>
    <div>

        <template v-if="field.link ">
            <router-link 
                :to="getLinkOptions(field.link, data)">
                {{ formatContent(data, field) }}
            </router-link>
        </template>

        <template v-else-if="field.date ">
            {{ formatDate(field.date, formatContent(data, field))}}
        </template>

        <template v-else>{{ formatContent(data, field) }}</template>

    </div>
</template>

<script>
import _formatDate from '@helpers/formatDate'
import _moneyFormat from '@helpers/moneyFormat'

export default {
    
    props: {
        field: {
            required: true,
            type: Object,
        },
        data: {
            required: true,
            type: Object,
        }
    },

    data(){
        return {

        }
    },

    methods: {

        /**
         * construct the param Object needed for the router-link .to.params
         * ie: params: {customerId: customer.id}} or callback
         * 
         * @param {Object} link 
         * @param {Object} data
         */ 
        buildLinkParamsObject(link, data){
            if (typeof(link.params) !== 'function') {
                return {[link.params.name] : data[link.params.property]};
            }

            return link.params(data);
        },

        /**
         * construct the object needed for the router-link .to
         * ie: {name: 'customer.show', params: {customerId: customer.id}}
         * 
         * @param {Object} link 
         * @param {Object} data
         */ 
        getLinkOptions(link, data){
            
            return {
                name: link.view,
                params: this.buildLinkParamsObject(link, data),
            }
        },

        formatDate(options, value) {
            return _formatDate(options, value)
        },

        formatContent(data, field) {
            let content = data[field.name];
            if (!content) return '';

            if (content.length > 25) {
                content = content.substr(0, 25) + "...";
            }

            if (field.percent) {
                content += '%';
            }

            if (field.money) {
                content = _moneyFormat(content, field.money);
            }

            return content;
        }
    }
    
}
</script>
