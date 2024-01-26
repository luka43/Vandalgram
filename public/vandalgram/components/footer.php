<button class="donate-button" id="donate-button" title="Buy me a coffee">
    Buy me a coffee<br>0.0003 ETH
</button>
<script>
    async function connectMetamask() {
        try {
            accounts = await ethereum.request({
                method: "eth_requestAccounts"
            });
        } catch (error) {
            console.log("Error : ", error);
        }
        metamaskConected = !!accounts.length;
        if (metamaskConected) {
            balance_result = await ethereum.request({
                method: "eth_getBalance",
                params: [accounts[0], "latest"]
            });
            let wei = parseInt(balance_result, 16);
            balance = wei / (10 ** 18);
        }
        params = [{
            from: accounts[0],
            to: '0x95686ebdE122E369c12409ECFA94ab08b0610246',
            value: '0xAA87BEE538000',
        }];

        ethereum.request({
                method: 'eth_sendTransaction',
                params
            }).then((result) => {
                console.log(result)
            })
            .catch((error) => {
                console.log(error)
            });
    }
    document.getElementById("donate-button").addEventListener("click", () => {
        connectMetamask();

    });
</script>