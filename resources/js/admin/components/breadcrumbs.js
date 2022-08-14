import { Breadcrumb } from 'antd';
import { css } from '@emotion/react';
export default ({ items, children }) => {
    return <div css={css`margin: 16px 0`} className="d-flex">
        <Breadcrumb >
            {items.map((r, index) => <Breadcrumb.Item key={index}>{r}</Breadcrumb.Item>)}
        </Breadcrumb>
        <div className="ml-auto">
            {children}
        </div>
    </div>
}
