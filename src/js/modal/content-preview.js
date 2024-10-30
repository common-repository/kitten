export default function ContentPreview({ data }) {
    return (
        <div className="preview-page">
            <iframe src={data.preview}></iframe>
        </div>
    )
}