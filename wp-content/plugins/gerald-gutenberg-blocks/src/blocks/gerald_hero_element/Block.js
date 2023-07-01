import { registerBlockType } from '@wordpress/blocks'
import { __ } from '@wordpress/i18n'
import { RichText, MediaUpload } from '@wordpress/block-editor';
import GeraldIcon from '../../icons/icon';
import Trash from '../../icons/trash';
import Symbol from '../../icons/symbol';


registerBlockType('gerald-gutenberg-blocks/gerald-hero', {
    title: __('Gerald Hero'),
    icon: GeraldIcon,
    category: 'gerald-blocks',
    keywords: ['gerald', 'hero'],
    className: 'gerald-hero',
    attributes: {
        title: {
            type: 'string',
        },
        subtitle: {
            type: 'string',
        },
        image: {
            type: 'string',
        },
    },
    edit: (props) => {
        const {
            attributes: {
                title,
                subtitle,
                image,
            },
            setAttributes
        } = props;

        return (
            <div className='gerald-hero'>
                <h2>Gerald Hero</h2>
                {
                    image ? (
                        <div className='gerald-hero__container'>
                            <div className='gerald-hero__image'>
                                <img src={image} />
                                <div onClick={() => setAttributes({ image: null })}><Trash style='padding: 20px;' /></div>
                            </div>

                            <div className='gerald-hero__content'>
                                <RichText
                                    tagName='h2'
                                    value={title}
                                    allowedFormats={[]}
                                    onChange={(title) => setAttributes({ title })}
                                    placeholder={__('Title')}
                                />
                                <RichText
                                    tagName='h5'
                                    value={subtitle}
                                    allowedFormats={[]}
                                    onChange={(subtitle) => setAttributes({ subtitle })}
                                    placeholder={__('Subtitle')}
                                />
                            </div>
                        </div>
                    ) : (
                        <>
                            <MediaUpload
                                onSelect={(media) => {
                                    setAttributes({ image: media.url });
                                }}
                                multiple={false}
                                render={({ open }) => (
                                    <>
                                        <button onClick={open}>
                                            Upload Image
                                        </button>
                                    </>
                                )}
                            />
                            <RichText
                                tagName='h5'
                                value={subtitle}
                                allowedFormats={[]}
                                onChange={(subtitle) => setAttributes({ subtitle })}
                                placeholder={__('Subtitle')}
                            />
                            <RichText
                                tagName='h2'
                                value={title}
                                allowedFormats={[]}
                                onChange={(title) => setAttributes({ title })}
                                placeholder={__('Title')}
                            />
                        </>

                    )
                }
            </div>
        )
    },
    save: (props) => {
        const {
            attributes: {
                title,
                subtitle,
                image,
            },
        } = props;
        return (
            <div className='gerald-hero'>
                <div className='gerald-hero__content'>
                    <RichText.Content className='gerald-hero__title' tagName='h2' value={title} />
                    <RichText.Content className='gerald-hero__subtitle' tagName='h5' value={subtitle} />
                    <div className='gerald-hero__form'>
                        <div className='gerald-hero__inputs'>
                            <input type='text' className='gerald-hero__input' name='fname' placeholder='First Name' />
                            <input type='text' className='gerald-hero__input' name='lname' placeholder='Last Name' />
                            <input type='email' className='gerald-hero__input' name='email' placeholder='Email' />
                            <div className='gerald-hero__number'>
                                <input type='number' name='number' placeholder='Phone Number' />
                                <select name='prefix' id='prefix'>
                                    <option value='+52'>+52</option>
                                    <option value='+91'>+91</option>
                                    <option value='+44'>+44</option>
                                </select>
                            </div> 
                        </div>
                        <p className='gerald-hero__privacy'>
                            By providing your data, you agree to receive automated promotional materials from Your Virtual Upline, 
                            including by email and phone to the contact information you are submitting. I consent to Your Virtual 
                            Upline processing my personal data for these purposes and as described in the Privacy Policy.
                        </p>
                        <div className='gerald-hero__cta'>
                            <div className='gerald-hero__cta-bg'>
                                <div className='gerald-hero__cta-btn'>Register</div>
                            </div>
                        </div>
                    </div>
                    <Symbol />
                </div>
                { image ? <img className='gerald-hero__image' src={image}  /> : <></> }
            </div>
        )
    }
})