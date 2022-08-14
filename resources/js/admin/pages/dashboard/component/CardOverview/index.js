import { Card, Tooltip } from 'antd'
import React from 'react'

export default function CardOverview(props) {
    return (

        <Card title={props.title} bordered={false}>
            <div className="position-absolute top-8-px end-8-px">
                <Tooltip placement="topLeft" title={props.title + " trong tháng"}>
                    {props.icon}
                </Tooltip>
            </div>
            <span style={{color: '#03a9f4', fontSize: '1rem'}}>
                {props.total ?? 0}
            </span>
        </Card>
    )
}
