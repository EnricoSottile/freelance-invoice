<template>
    <div>

        <template v-if="field.link ">
            <router-link 
                :to="getLinkOptions(field.link, data)">
                {{ getContent(data, field) }}
            </router-link>
        </template>

        <template v-else-if="field.date ">
            {{ formatDate(field.date, getContent(data, field))}}
        </template>

        <template v-else>{{ getContent(data, field) }}</template>

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
         * construct the object needed for the router-link .to
         * ie: {name: 'customer.show', params: {customerId: customer.id}}
         * 
         * @param {Object} link 
         * @param {Object} data
         */ 
        getLinkOptions(link, data){
            return {
                name: link.view,
                params: {
                    [link.params.name]: data[link.params.property]
                }
            }
        },

        formatDate(options, value) {
            return _formatDate(options, value)
        },

        getContent(data, field) {
            let content = data[field.name];
            if (!content || !content.length) return content;

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
