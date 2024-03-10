const { registerBlockType } = wp.blocks;
const { InspectorControls } = wp.editor;
const { PanelBody, TextControl } = wp.components;
console.log('js chargé')
registerBlockType('custom/guestrooms-block', {
    title: 'Bloc Chambres',
    icon: 'format-gallery',
    category: 'common',

    attributes: {
        numberOfColumns: {
            type: 'number',
            default: 2,
        },
    },

    edit: function (props) {
        const { attributes, setAttributes } = props;

        const onChangeNumberOfColumns = (value) => {
            setAttributes({ numberOfColumns: value });
        };

        return true
    },

    save: function ({ attributes }) {
        const columns = Array.from({ length: attributes.numberOfColumns }, (_, index) => index + 1);

        return true
    },
});
