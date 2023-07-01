import { registerBlockType } from '@wordpress/blocks'
import { __ } from '@wordpress/i18n'
import { RichText } from '@wordpress/block-editor';
import GeraldIcon from '../../icons/icon';


registerBlockType('gerald-gutenberg-blocks/gerald-course-grid', {
    title: __('Gerald Course Grid'),
    icon: GeraldIcon,
    category: 'gerald-blocks',
    keywords: ['gerald', 'course', 'grid'],
    className: 'gerald-course-grid',
    attributes: {
        title: {
            type: 'string',
        },
    },
    edit: (props) => {
        const {
            attributes: {
                title
            },
            setAttributes
        } = props;

        return (
            <div className='gerald-course-grid'>
                <h2>Gerald Course Grid</h2>
                <RichText
                    tagName='h2'
                    value={title}
                    allowedFormats={[]}
                    onChange={(title) => setAttributes({ title })}
                    placeholder={__('Title')}
                />
            </div>
        )
    },
    save: () => null
})