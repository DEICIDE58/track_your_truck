private void sendLocationToServer(double latitude, double longitude) {
    OkHttpClient client = new OkHttpClient();
    String url = "http://localhost/Track_your_Truck/";

    RequestBody formBody = new FormBody.Builder()
            .add("latitude", String.valueOf(latitude))
            .add("longitude", String.valueOf(longitude))
            .build();

    Request request = new Request.Builder()
            .url(url)
            .post(formBody)
            .build();

    client.newCall(request).enqueue(new Callback() {
        @Override
        public void onFailure(Call call, IOException e) {
            e.printStackTrace();
        }

        @Override
        public void onResponse(Call call, Response response) throws IOException {
            if (response.isSuccessful()) {
                System.out.println("Location sent successfully!");
            }
        }
    });
}
