import { Select, Spin } from 'antd';
import { useQuery } from 'react-query';
import { useState, useEffect } from 'react';
import { css } from '@emotion/react';
const { Option } = Select;

const MailjetSelect = ({ onChange, value, ...props }) => {

    const { isLoading, data } = useQuery(['mailjet'], async () => {
        const { data } = await axios.get("/api/admin/mailjet");
        return data;
    });

    return (
        <Select
            filterOption={false}
            notFoundContent={isLoading ? <Spin size="small" /> : null}
            onChange={onChange}
            value={value}
            optionLabelProp="label"
            {...props}
        >
            {
                data && data.map(item => <Option key={item.id} value={item.id} label={item.name}>
                    <div className="d-flex align-items-center">
                        <img src={item.preview} css={css`width:150px`} />
                        <p className="ml-3">{item.name}</p>
                    </div>
                </Option>)
            }
        </Select>
    );
};
export default MailjetSelect;
