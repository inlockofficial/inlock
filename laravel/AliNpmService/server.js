const express = require("express");
const cors = require("cors");
const axios = require("axios");
const cheerio = require("cheerio");

const app = express();

app.use(cors());
app.use(express.json());

app.post("/product", async (req, res) => {
    try {
        const { url } = req.body;

        if (!url) {
            return res.status(400).json({
                error: "URL required"
            });
        }

        // Fetch AliExpress page
        const response = await axios.get(url, {
            headers: {
                "User-Agent":
                    "Mozilla/5.0 (Windows NT 10.0; Win64; x64)"
            }
        });

        const html = response.data;

        // ===============================
// UNIVERSAL ALIEXPRESS EXTRACTOR
// ===============================

let jsonData = null;

// 1️⃣ Modern AliExpress (__NEXT_DATA__)
const nextDataMatch = html.match(
    /<script id="__NEXT_DATA__" type="application\/json">(.*?)<\/script>/
);

if (nextDataMatch) {
    jsonData = JSON.parse(nextDataMatch[1]);
}

// 2️⃣ Old AliExpress fallback (runParams)
if (!jsonData) {
    const runParamsMatch = html.match(
        /window\.runParams\s*=\s*(\{.*?\});/s
    );

    if (runParamsMatch) {
        jsonData = JSON.parse(runParamsMatch[1]);
    }
}

if (!jsonData) {
    throw new Error("AliExpress product data not found");
}

// ===============================
// EXTRACT PRODUCT INFO
// ===============================

let title = null;
let price = null;
let images = [];

// New layout
if (jsonData.props) {
    const product =
        jsonData.props.pageProps?.data ||
        jsonData.props.pageProps?.productInfoComponent;

    title = product?.titleModule?.subject || null;

    price =
        product?.priceModule?.minActivityAmount?.value ||
        product?.priceModule?.minAmount?.value ||
        null;

    images = product?.imageModule?.imagePathList || [];
}

// Old layout fallback
if (!title && jsonData.titleModule) {
    title = jsonData.titleModule.subject;
    price = jsonData.priceModule?.minActivityAmount?.value;
    images = jsonData.imageModule?.imagePathList || [];
}

        res.json({
            title,
            price,
            images
        });

    } catch (err) {
        console.error("FETCH ERROR:", err.message);

        res.status(500).json({
            error: "Failed to fetch product",
            details: err.message
        });
    }
});

app.listen(3001, () => {
    console.log("AliExpress scraper running on port 3001");
});

