import { css } from '@emotion/react';
import {
    QueryClient,
    QueryClientProvider,
} from 'react-query'

import {
    BrowserRouter,
    Routes,
    Route
} from "react-router-dom";

const queryClient = new QueryClient()
import Content from './content';

const App = () => {

    return (
        <QueryClientProvider client={queryClient}>
            <div id="client" css={css`
            max-width:640px;
            margin:0 auto 10px;
        `}>
                <BrowserRouter>
                    <Routes>
                        <Route path=":slug" element={<Content />} />
                    </Routes>
                </BrowserRouter>
            </div>
        </QueryClientProvider >
    );
};

export default App;
