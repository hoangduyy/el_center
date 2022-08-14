import {
  message, Skeleton,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate, useParams } from 'react-router';
import { useQueryClient, useQuery } from 'react-query';
import Form from './form';
import { useState } from "react";

const EditQuestionPage = () => {
  const navigate = useNavigate();
  const queryClient = useQueryClient();
  const { id } = useParams();
  const [content, setContent] = useState('')

  const { isLoading, data } = useQuery(['question', [id]], async () => {
      const { data } = await axios.get("/api/admin/question/" + id + '/edit');
      return { ...data, question: data.question, da_a: data.da_a, da_b: data.da_b, da_c: data.da_c, da_d: data.da_d, da: data.da };
  });

  const onFinish = async (values) => {
      try {
          values = { ...values}
          console.log(values ,'values');
          await axios.put("/api/admin/question/" + id , values);
          message.success("Sửa thành công");
          queryClient.invalidateQueries("question");
          navigate("/admin/question");
      } catch ({ response }) {
        const { data } = response;
        const { error } = data;
        let errorMessage = "Error";

        for (const [key, value] of Object.entries(error)) {
            errorMessage = value;
        }
        message.error(errorMessage);
      }
  };

  return <div>
      <Breadcrumb items={["Bộ câu hỏi", "Chỉnh sửa"]} />
      <div className="site-layout-background" style={{ padding: 24, minHeight: 360 }}>
          <div className="d-flex justify-content-center" >
              <Skeleton active loading={isLoading}>
                  <Form
                      isEdit
                      initialValues={data}
                      onFinish={onFinish}
                      onChecked={(value) => setStatus(value)}
                      onEditor={(data) => setContent(data)}
                  />
              </Skeleton>
          </div>
      </div>
  </div>
}
export default EditQuestionPage;
