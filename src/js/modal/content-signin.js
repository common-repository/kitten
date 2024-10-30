import { useState } from "react"
import $ from 'jquery'

export default function ContentSignIn({ setCredentials }) {
    const [fetch, setFetch] = useState(false);
    const [fetchError, setFetchError] = useState('');

    const [credential, setCredential] = useState({
        email: '',
        password: ''
    });

    function handleInput(e) {
        setCredential({...credential, [e.target.getAttribute('name')]: e.target.value})
    }

    function handleSubmit(e) {
        e.preventDefault()
        $.ajax({
            url: kitten.ajaxUrl,
            method: 'post',
            data: {
                action: 'dg_handle_login_credentials',
                form: credential
            },
            beforeSend: () => {
                setFetch(true)
                setFetchError('')
            },
        }).then((response) => {
            if (response.success) {
                setCredentials(response.data)
            } else {
                setFetchError(response.message)
            }
            setFetch(false)
        })
    }

    return (
        <div className="signin-to">
            {fetchError && (
                <div className="error-message" dangerouslySetInnerHTML={{__html: fetchError}}></div>
            )}
            <form action="">
                <div className="signin-form">
                    <label htmlFor="">Email</label>
                    <input type="email" name="email" onChange={handleInput} placeholder="email@example.com" />
                </div>
                <div className="signin-form">
                    <label htmlFor="">Password</label>
                    <input type="password" name="password" onChange={handleInput} placeholder="*************" />
                </div>
                <div className="signin-action">
                    <button onClick={handleSubmit} type="submit" disabled={fetch}>{!fetch ? 'Login to DesGrammer' : 'Please wait..'}</button>
                </div>
            </form>
        </div>
    )
}