import React, { useState } from 'react';
import axios from 'axios';

const API_BASE_URL = process.env.NEXT_PUBLIC_API_URL || '';

const ImageUpload = () => {
    const [selectedFile, setSelectedFile] = useState(null);
    const [previewUrl, setPreviewUrl] = useState(null);
    const [message, setMessage] = useState('');

    const handleFileSelect = (event) => {
        const file = event.target.files[0];
        setSelectedFile(file);

        // プレビュー表示
        if (file) {
            const reader = new FileReader();
            reader.onloadend = () => {
                setPreviewUrl(reader.result);
            };
            reader.readAsDataURL(file);
        }
    };

    const handleUpload = async () => {
        if (!selectedFile) {
            setMessage('ファイルを選択してください。');
            return;
        }

        const formData = new FormData();
        formData.append('image', selectedFile);

        try {
            const response = await axios.post(`${API_BASE_URL}/api/upload-image`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-Requested-With': 'XMLHttpRequest',
                }
            });

            setMessage('アップロード成功！');
            console.log('アップロードされた画像のパス:', response.data.path);
        } catch (error) {
            setMessage('アップロード失敗: ' + error.message);
        }
    };

    return (
        <div className="image-upload-container">
            <input
                type="file"
                accept="image/*"
                onChange={handleFileSelect}
                className="file-input"
            />
            
            {previewUrl && (
                <div className="preview-container">
                    <img src={previewUrl} alt="プレビュー" style={{ maxWidth: '200px' }} />
                </div>
            )}

            <button
                onClick={handleUpload}
                className="upload-button"
                disabled={!selectedFile}
            >
                アップロード
            </button>

            {message && <p className="message">{message}</p>}
        </div>
    );
};

export default ImageUpload; 