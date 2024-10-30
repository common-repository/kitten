import { useEffect, useState } from "react"

export default function ContentBlocks() {
    const [loaded, setLoaded] = useState(false);
    const [kit, setKit] = useState([]);

    useEffect(() => {
        if (!loaded) {
            jQuery.ajax({
                url: 'https://kit.desgrammer.com/wp-json/kitten/v1/templates?type=blocks',
                beforeSend: () => setLoaded(false)
            }).then((response) => {
                setKit(response)
                setLoaded(true)
            })
        }
    })

    return (
        <p>block bro</p>
    )
}