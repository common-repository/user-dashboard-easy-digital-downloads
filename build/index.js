/* This section of the code registers a new block, sets an icon and a category, and indicates what type of fields it'll include. */
( function ( blocks, element, blockEditor ) {
    var el = element.createElement;
    var useBlockProps = blockEditor.useBlockProps;
 
    blocks.registerBlockType( 'user-dashboard-for-edd/dash-shortcode', {
        apiVersion: 2,
        title: 'EDD User Dashboard',
        icon: 'dashboard',
        category: 'common',
        example: {},
        edit: function () {
            var blockProps = useBlockProps(  );
            return el(
                'p',
                blockProps,
                '[edd-dash]'
            );
        },
        save: function () {
            var blockProps = useBlockProps.save(  );
            return el(
                'div',
                blockProps,
                '[edd-dash]'
            );
        },
    } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor );