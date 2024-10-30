import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';

import ContentBlocks from './modal/content-blocks';
import ContentChild from './modal/content-child';
import ContentLandingPages from './modal/content-landing-pages';
import ContentPreview from './modal/content-preview';
import ContentSignIn from './modal/content-signin';
import ContentTemplates from './modal/content-templates';
import importElementor from './services/elementor';

function App({ credentials }) {
    const [localCredentials, setLocalCredentials] = useState(credentials);

    const [page, setPage] = useState('main');
    const [section, setSection] = useState('templates');
    const [kitSingle, setKitSingle] = useState(0);
    const [content, setContent] = useState({
        preview: '',
        content: {}
    });

    function setSingle(id) {
        setPage('child')
        setKitSingle(id)
    }

    function onMenuClick(section) {
        setPage('main')
        setSection(section)
        setKitSingle(0)
    }

    function onBackClick() {
        if ('templates' === section) {
            if (page === 'child') {
                setPage('main');
                setKitSingle(0)
            } else if(page === 'preview') {
                setPage('child')
            }
        } else if ('landing-pages' === section) {
            setPage('main');
            setKitSingle(0)
        }
    }

    function setPreview(content) {
        setContent(content)
        setPage('preview')
    }

    function whichSection(section) {
        switch (section) {
            case 'templates':
                return <ContentTemplates token={localCredentials.token} setSingle={(id) => setSingle(id)} />;
            case 'landing-pages':
                return <ContentLandingPages token={localCredentials.token} content={content} setPreview={(content) => {setPreview(content)}} />;
            case 'blocks':
                return <ContentBlocks />;
        }
    }

    return (
        <div className="kitten-editor-backdrop">
            <div className="kitten-editor-modal">
                <div className="kitten-modal-close">
                    {(page === 'preview') && (
                        <a className="import" onClick={() => importElementor(content.content.content, content.content.page_settings)}>import Template</a>
                    )}
                    {(page !== 'main') && (
                        <a className="back" onClick={() => onBackClick()}>
                            <i className="dashicons dashicons-arrow-left-alt"></i>
                        </a>
                    )}
                    <a className="close" href="#">
                        <i className="dashicons dashicons-no"></i>
                    </a>
                </div>
                <div className="kitten-modal-header">
                    <div className="logo">
                        <img width="30" height="30" src="/wp-content/plugins/kitten/assets/images/kitten-logo.png" alt="" />
                        <h3>itten</h3>
                    </div>
                    <div className="tab">
                        <ul>
                            <li><a onClick={() => onMenuClick('templates')} className={section === 'templates' ? 'active' : ''}>Template Kits</a></li>
                            <li><a onClick={() => onMenuClick('landing-pages')} className={section === 'landing-pages' ? 'active' : ''}>Landing Page</a></li>
                            <li><a onClick={() => alert('Belum ada nih, Coming Soon yaa!')} className={section === 'blocks' ? 'active' : ''}>Block Section</a></li>
                            <li><a onClick={() => alert('Belum ada nih, Coming Soon yaa!') /* onMenuClick('my-templates') */} className={section === 'my-templates' ? 'active' : ''}>My Template Kits</a></li>
                        </ul>
                    </div>
                    {/* {(localCredentials && undefined !== localCredentials.token) ? (
                    ) : ''} */}
                </div>
                {/* {(localCredentials && undefined !== localCredentials.token) ? (
                    <> */}
                        <div className="kitten-modal-content">
                            {(kitSingle === 0 && 'preview' !== page) && whichSection(section)}
                            {(kitSingle !== 0 && 'preview' !== page) && (
                                <ContentChild token={localCredentials.token} id={kitSingle} content={content} setContent={(content) => setPreview(content)} />
                            )}
                            {(page === 'preview') && (
                                <ContentPreview data={content} />
                            )}
                        </div>
                    {/* </>) : <>
                        <ContentSignIn setCredentials={(cred) => setLocalCredentials(cred)} />
                    </>} */}
            </div>
        </div>
    )
}

elementor.on('preview:loaded', function () {
    ReactDOM.render(<App credentials={kitten.credentials} />, document.getElementById('kittenEditorModal'));
})