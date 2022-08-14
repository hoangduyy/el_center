import React, { useState } from 'react';
import { useSearchParams, useLocation, useParams } from "react-router-dom";
import { Input, Tooltip, Button, Tabs, Typography, Skeleton, List, Avatar, message, Result, Spin } from 'antd';
const { TabPane } = Tabs;
import { CopyOutlined } from '@ant-design/icons';
import { css } from '@emotion/react';
const { Title, Text, Paragraph } = Typography;
import {
    useQuery,
} from 'react-query'
import moment from 'moment';
import copy from 'copy-to-clipboard';


const Content = () => {
    const { slug } = useParams();
    const location = useLocation();

    const { isLoading: isLoadingCampaign, data: campaignRes } = useQuery(['campaign'], async () => {
        const { data } = await axios.get("/api/campaign/" + slug);
        return data;
    });
    const { phone } = Object.fromEntries(new URLSearchParams(location.search));
    const [search, setSearch] = useState(phone)

    const { isLoading: isProfileLoading, data: profileData } = useQuery(['profile', campaignRes, search], async () => {
        if (!campaignRes || campaignRes.code != 0 || !search) return null;
        const { data } = await axios.get(`/api/${slug}/profile`, {
            params: {
                phone: search
            }
        });
        return data;
    });

    const { isLoading: isTopLoading, data: topData } = useQuery(['top', campaignRes], async () => {
        if (!campaignRes || campaignRes.code != 0) return null;
        const { data } = await axios.get(`/api/${slug}/top`)
        return data;
    });
    if (isLoadingCampaign) {
        return <Spin />
    }
    if (campaignRes.code != 0) {
        return <Result
            status="404"
            title="404"
            subTitle="Xin lỗi trang không tồn tại."
        />
    }

    return (
        <div>
            <div>
                <img
                    css={css`width:100%`}
                    src={asset("storage/" + campaignRes.data.banner)} />
            </div>
            <Tabs tabBarExtraContent={profileData?.name ? <h5>Chào: {profileData.name}</h5> : null} css={css`background:#fff;padding:0 10px;margin-top:10px;padding-bottom:20px`}>
                <TabPane tab="Link" key="1">
                    <Skeleton loading={isProfileLoading} active>
                        <RefLink link={campaignRes.data.url} slug={slug} onSearch={s => setSearch(s)} refLink={profileData?.ref} />
                    </Skeleton>
                </TabPane>
                <TabPane tab="Đã mời" key="2">
                    <Skeleton loading={isProfileLoading} active>
                        <Invited slug={slug} onSearch={s => setSearch(s)} invited={profileData?.invited} />
                    </Skeleton>
                </TabPane>
                <TabPane tab="Top 10" key="3">
                    <Skeleton loading={isTopLoading} active>
                        <Top slug={slug} data={topData} />
                    </Skeleton>
                </TabPane>
            </Tabs>

        </div>
    );
};

export default Content;


const RefLink = ({ refLink, onSearch, link }) => {
    if (!refLink) {
        return <Search onSearch={onSearch} />
    }

    const copyLink = (e) => {
        copy(`${link}?ref=${refLink}`);
        message.info('Đã copy link vào bộ nhớ');
    }

    return <div css={css`max-width:450px; margin:20px auto 10px`}>
        <div css={css`text-align:center;margin-bottom:10px`}>
            <Title level={5}>LINK GIỚI THIỆU</Title>
            <Paragraph>Hãy chia sẻ cho bạn bè để nhận được những món quà đặc biệt từ Nobita nhé.</Paragraph>
            <Text css={css`text-align:center;width:100%`}>Link giới thiệu dành riêng cho bạn</Text>
        </div>
        <Input.Group compact>
            <Input value={`${link}?ref=${refLink}`}
                readOnly
                css={css`width: calc(100% - 31px)!important`}
            />
            <Tooltip title="Copy link">
                <Button icon={<CopyOutlined onClick={copyLink} />} />
            </Tooltip>
        </Input.Group>
    </div>
}
const Invited = ({ invited, onSearch }) => {
    if (!invited) {
        return <Search onSearch={onSearch} />
    }

    return <List
        itemLayout="horizontal"
        dataSource={invited}
        header={<div css={css`display:flex`}>
            <div css={css`width:50px`}>STT</div>
            <div css={css`flex:1;text-center`}>Họ và tên</div>
            <div css={css`width:100px`}>Đăng ký</div>
        </div>}
        renderItem={(item, index) => (
            <List.Item>
                <div css={css`width:50px`}>{index + 1}</div>
                <div
                    css={css`flex:1`}
                >
                    {item.name}
                </div>
                <div css={css`width:130px`}>
                    {moment(item.created_at).format("L hh:mm")}
                </div>
            </List.Item>
        )}
    />
}
const Top = ({ data }) => {
    return <List
        itemLayout="horizontal"
        dataSource={data}
        header={<div css={css`display:flex`}>
            <div css={css`width:50px`}>STT</div>
            <div css={css`flex:1`}>Họ và tên</div>
            <div css={css`width:100px`}>Ref</div>
        </div>
        }
        renderItem={(item, index) => (
            <List.Item>
                <div css={css`width:50px`}>{index + 1}</div>
                <div
                    css={css`flex:1`}
                >
                    {item.name}
                </div>
                <div css={css`width:80px`}>
                    {item.invited_count}
                </div>
            </List.Item>
        )}
    />
}

const Search = ({
    onSearch,
}) => {
    const [value, setValue] = useState(null);
    let [searchParams, setSearchParams] = useSearchParams();

    const login = () => {
        setSearchParams({
            phone: value
        })
        onSearch(value)
    }
    return <div css={css`max-width:450px; margin:20px auto 10px`}>
        <div css={css`text-align:center;margin-bottom:10px`}>
            <Title level={5}>Đăng nhập</Title>
        </div>
        <Input.Group compact>
            <Input
                css={css`width: calc(100% - 100px)!important`}
                placeholder="Số điện thoại"
                value={value}
                onChange={e => setValue(e.target.value)}
            />
            <Button onClick={login} type="primary">Đăng nhập</Button>
        </Input.Group>
    </div >
}
