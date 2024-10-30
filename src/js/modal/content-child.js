import { useEffect, useState } from "react"
import $ from 'jquery'

export default function ContentChild({ id, content, setContent, token }) {
    const [loaded, setLoaded] = useState(false);
    const [kit, setKit] = useState([]);

    useEffect(() => {
        if (!loaded && id !== 0 && id !== undefined) {
            $.ajax({
                url: 'https://kit.desgrammer.com/wp-json/kitten/v1/templates/' + id,
                beforeSend: (xhr) => {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                    setLoaded(false)
                },
            }).then((response) => {
                setKit(response)
                setLoaded(true)
            })
        }
    }, [loaded])

    function setContentPreview(newContent, preview) {
        let updatedContent = content;
        updatedContent['content'] = newContent;
        updatedContent['preview'] = preview;
        setContent(updatedContent)
    }

    return (
        <div className="kitten-content-wrapper">
            {loaded && kit.map((value) => (
                <div key={value.id} className="content-single">
                    <div className="image-preview">
                        <a href="#" onClick={() => setContentPreview(value.content, value.preview)}>
                            <img src={value.thumbnail} alt="" />
                        </a>
                    </div>
                    <div className="text-preview">
                        <h3>{value.name}</h3>
                        {(value.template_count !== undefined && value.template_count !== 0) && (
                            <span>{value.template_count} Template included</span>
                        )}
                    </div>
                </div>
            ))}
            {!loaded && (
                <>
                    <div className="content-load-single">
                        <div className="load-text"></div>
                        <div className="load-desc"></div>
                    </div>
                    <div className="content-load-single">
                        <div className="load-text"></div>
                        <div className="load-desc"></div>
                    </div>
                    <div className="content-load-single">
                        <div className="load-text"></div>
                        <div className="load-desc"></div>
                    </div>
                    <div className="content-load-single">
                        <div className="load-text"></div>
                        <div className="load-desc"></div>
                    </div>
                </>
            )}
        </div>
    )
}