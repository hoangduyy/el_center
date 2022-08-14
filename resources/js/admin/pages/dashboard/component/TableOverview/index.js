import React from "react";
import { Table } from "antd";
import moment from "moment";
export default function TableOverview({ data }) {
  const columns = [
    {
      title: "Sản phẩm",
      dataIndex: "title",
      key: "title",
      render: (_, record) => (
        <span>
          23123212
          {record.name?.length > 40
            ? record.name.substring(0, 40) + "..."
            : record.name}
        </span>
      ),
    },
    {
      title: "Số lượng",
      dataIndex: "name",
      key: "name",
      render: (_, record) => <span>  {record.name?.length > 40
        ? record.name.substring(0, 40) + "..."
        : record.name}</span>,
    },
    {
      title: "Thành tiền",
      dataIndex: "time",
      key: "time",
      render: (_, record) => (
        <span>
          213123
          {moment(record.createdAt).format("DD/MM/yyyy") +
            " - " +
            moment(record.endDate).format("DD/MM/yyyy")}
        </span>
      ),
    },
  ];

  return <Table columns={columns} dataSource={data} pagination={false} />;
}
