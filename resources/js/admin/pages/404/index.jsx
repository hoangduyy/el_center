import React from 'react';
import "./404.scss";
import {
    AndroidOutlined
} from '@ant-design/icons';

export default function NotFoundPage() {
    return (
        <div className="page-err">
            <h1 className="page-err__code">4<span><AndroidOutlined /></span>4</h1>
            <h2 className="page-err__title">Error: 404 page not found</h2>
            <p className="page-err__des">Sorry, the page you're looking for cannot be accessed</p>
        </div>
    )
}