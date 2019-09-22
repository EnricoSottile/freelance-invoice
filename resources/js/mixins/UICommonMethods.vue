<script>
    import _getIcon from '@helpers/getIcon'
    import _formatDate from '@helpers/formatDate'

    export default {
        
        methods: {
            formatDate(options, value) {
                return _formatDate(options, value)
            },
            getIcon(icon) {
                return _getIcon(icon);
            }
        }
        
    }
</script>