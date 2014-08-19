package com.colors.supersaym.controller.communication;

import java.io.ByteArrayInputStream;
import java.io.IOException;
import java.net.UnknownHostException;
import java.security.KeyStore;
import java.util.ArrayList;

import javax.net.ssl.HttpsURLConnection;
import javax.net.ssl.SSLContext;
import javax.net.ssl.TrustManager;
import javax.net.ssl.X509TrustManager;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.HttpVersion;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.conn.ClientConnectionManager;
import org.apache.http.conn.HttpHostConnectException;
import org.apache.http.conn.scheme.PlainSocketFactory;
import org.apache.http.conn.scheme.Scheme;
import org.apache.http.conn.scheme.SchemeRegistry;
import org.apache.http.conn.ssl.SSLSocketFactory;
import org.apache.http.entity.BasicHttpEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.impl.conn.SingleClientConnManager;
import org.apache.http.impl.conn.tsccm.ThreadSafeClientConnManager;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;
import org.apache.http.params.HttpProtocolParams;
import org.apache.http.protocol.HTTP;
import org.apache.http.util.EntityUtils;

import android.content.Context;
import android.util.Log;

public class Communication {

	private static int TIMEOUT_MILLISEC = 5000;
	public static String Base_URL="	http://hitseven.net/mobile/index.php?/api/hitcall/";
	private static DefaultHttpClient h;

	/**
	 * Execute web service of type Get
	 * 
	 * @param url
	 *            :The URL of web service
	 * @param headers
	 *            :Headers of HTTP connection
	 * @return response object contains status code and response string
	 */
	public static ResponseObject getMethod(String url,
			ArrayList<RequestHeader> headers, Context context) {
		ResponseObject responseObject = new ResponseObject();
		try {
			if (!ConnectionDetector.getInstance(context)
					.isConnectingToInternet()) {
				responseObject
						.setStatusCode(StatusCodeConstants.STATUS_CODE_NO_CONNECTION);
				return responseObject;
			}
			HttpParams httpParams = new BasicHttpParams();
			HttpConnectionParams.setConnectionTimeout(httpParams,
					TIMEOUT_MILLISEC);
			HttpConnectionParams.setSoTimeout(httpParams, TIMEOUT_MILLISEC);
			DefaultHttpClient client = getHTTPSClient();
			HttpGet request = new HttpGet(url);
			if (headers != null) {
				for (RequestHeader header : headers)
					request.addHeader(header.getKey(), header.getValue());
			}
Log.d("Shaimaa", "Request "+request.getURI().getHost());
			HttpResponse response = client.execute(request);

			responseObject.setStatusCode(response.getStatusLine()
					.getStatusCode());

			if (responseObject.getStatusCode() == StatusCodeConstants.STATUS_CODE_OK
					|| responseObject.getStatusCode() == StatusCodeConstants.STATUS_CODE_NOT_ACCEPTABLE) {
				HttpEntity entity = response.getEntity();
				if (entity != null)
					responseObject.setResponseString(EntityUtils.toString(
							entity, "UTF-8"));
			}

		} catch (ClientProtocolException e) {
			e.printStackTrace();
			responseObject.setResponseString(" ");
		} catch (UnknownHostException e) {
			e.printStackTrace();
			responseObject
					.setStatusCode(StatusCodeConstants.STATUS_CODE_UNKNOWN_HOST_EXCEPTION);
			responseObject.setResponseString(" ");
		} catch (HttpHostConnectException e) {
			e.printStackTrace();
			responseObject
					.setStatusCode(StatusCodeConstants.STATUS_CODE_HTTP_HOST_CONNECTION_EXCEPTION);
			responseObject.setResponseString(" ");
		} catch (IOException e) {
			e.printStackTrace();
			responseObject
					.setStatusCode(StatusCodeConstants.STATUS_CODE_IO_EXCEPTION);
			responseObject.setResponseString(" ");
		} catch (Exception e) {
			e.printStackTrace();
			responseObject
					.setStatusCode(StatusCodeConstants.STATUS_CODE_EXCEPTION);
			responseObject.setResponseString(" ");
		}
		// /log response
		Log.d("Shaimaa", responseObject.getResponseString());

		return responseObject;
	}

	/**
	 * Execute web service of type Post
	 * 
	 * @param url
	 *            :The URL of web service
	 * @param headers
	 *            :Headers of HTTP connection
	 * @param body
	 *            :the request of web service
	 */
	public static ResponseObject postMethod(String url, ArrayList<RequestHeader> headers,
			Context context) {
		ResponseObject responseObject = new ResponseObject();

		try {
			HttpParams httpParams = new BasicHttpParams();
			HttpConnectionParams.setConnectionTimeout(httpParams,
					TIMEOUT_MILLISEC);
			HttpConnectionParams.setSoTimeout(httpParams, TIMEOUT_MILLISEC);

			DefaultHttpClient client = getHTTPSClient();
			HttpPost request = new HttpPost(url);

			if (headers != null) {
				for (RequestHeader header : headers)
					request.addHeader(header.getKey(), header.getValue());
			}
			HttpResponse response = client.execute(request);

			 responseObject.setStatusCode(response.getStatusLine().getStatusCode());
			
			 if(responseObject.getStatusCode() ==
			 StatusCodeConstants.STATUS_CODE_OK ||
			 responseObject.getStatusCode() ==
			 StatusCodeConstants.STATUS_CODE_NOT_ACCEPTABLE)
			 {
			 HttpEntity entity = response.getEntity();
			 if(entity!=null)
			 responseObject.setResponseString(EntityUtils.toString(entity,"UTF-8"));
			 }

		} catch (ClientProtocolException e) {
			e.printStackTrace();
			 responseObject.setResponseString(" ");
		} catch (UnknownHostException e) {
			e.printStackTrace();
			 responseObject.setStatusCode(StatusCodeConstants.STATUS_CODE_UNKNOWN_HOST_EXCEPTION);
			 responseObject.setResponseString(" ");
		} catch (HttpHostConnectException e) {
			e.printStackTrace();
			 responseObject.setStatusCode(StatusCodeConstants.STATUS_CODE_HTTP_HOST_CONNECTION_EXCEPTION);
			 responseObject.setResponseString(" ");
		} catch (IOException e) {
			e.printStackTrace();
			 responseObject.setStatusCode(StatusCodeConstants.STATUS_CODE_IO_EXCEPTION);
			 responseObject.setResponseString(" ");
		} catch (Exception e) {
			e.printStackTrace();
			 responseObject.setStatusCode(StatusCodeConstants.STATUS_CODE_EXCEPTION);
			 responseObject.setResponseString(" ");
		}
		 Log.i("Response", responseObject.getResponseString());
		// LogUtility.i("Response", responseObject.getResponseString());
		 return responseObject;
	}

	/**
	 * Establish HTTPS connection
	 * 
	 * @return HTTP client
	 */
	public static DefaultHttpClient getHTTPSClient() 
	{
		try 
		{
			KeyStore trustStore = KeyStore.getInstance(KeyStore
					.getDefaultType());
			trustStore.load(null, null);

			SSLSocketFactory sf = new SSLSocketFactoryEx(trustStore);
			sf.setHostnameVerifier(SSLSocketFactory.ALLOW_ALL_HOSTNAME_VERIFIER);

			HttpParams params = new BasicHttpParams();
			HttpProtocolParams.setVersion(params, HttpVersion.HTTP_1_1);
			HttpProtocolParams.setContentCharset(params, HTTP.UTF_8);

			SchemeRegistry registry = new SchemeRegistry();
			registry.register(new Scheme("http", PlainSocketFactory
					.getSocketFactory(), 80));
			registry.register(new Scheme("https", sf, 443));

			ClientConnectionManager ccm = new ThreadSafeClientConnManager(
					params, registry);

			return new DefaultHttpClient(ccm, params);
		} catch (Exception e) 
		{
			return new DefaultHttpClient();
		}
	}

//	private void bypassCertificate() {
//		// Create a trust manager that does not validate certificate chains
//		TrustManager[] trustAllCerts = new TrustManager[] { new X509TrustManager() {
//			public java.security.cert.X509Certificate[] getAcceptedIssuers() {
//				return null;
//			}
//
//			public void checkClientTrusted(
//					java.security.cert.X509Certificate[] certs, String authType) {
//			}
//
//			public void checkServerTrusted(
//					java.security.cert.X509Certificate[] certs, String authType) {
//			}
//		} };
//
//		// Install the all-trusting trust manager
//		try {
//			SSLContext sc = SSLContext.getInstance("SSL");
//			sc.init(null, trustAllCerts, new java.security.SecureRandom());
//			HttpsURLConnection
//					.setDefaultSSLSocketFactory(sc.getSocketFactory());
//		} catch (Exception e) {
//		}
//
//		// // Now you can access an https URL without having the certificate in
//		// the truststore
//		// // It should work with expired certificate as well
//		// try {
//		// URL myUrl = new URL("https://www.....");
//		// } catch (MalformedURLException e) {
//		// }
//	}

	// /post method with body
	public static ResponseObject postMethodWithBody(String url,
			ArrayList<RequestHeader> headers, String body, Context context) {

		ResponseObject responseObject = new ResponseObject();
		try {
			if (!ConnectionDetector.getInstance(context)
					.isConnectingToInternet()) {
				responseObject
						.setStatusCode(StatusCodeConstants.STATUS_CODE_NO_CONNECTION);
				return responseObject;
			}
			HttpParams httpParams = new BasicHttpParams();
			HttpConnectionParams.setConnectionTimeout(httpParams,
					TIMEOUT_MILLISEC);
			HttpConnectionParams.setSoTimeout(httpParams, TIMEOUT_MILLISEC);

			DefaultHttpClient client = getHTTPSClient();
			HttpPost request = new HttpPost(url);

			BasicHttpEntity basicHttpEntity = new BasicHttpEntity();
			byte bytes[] = body.getBytes();

			basicHttpEntity.setContent(new ByteArrayInputStream(bytes));
			request.setEntity(basicHttpEntity);
			if (headers != null) {
				for (RequestHeader header : headers)
					request.addHeader(header.getKey(), header.getValue());
			}
			HttpResponse response = client.execute(request);

			responseObject.setStatusCode(response.getStatusLine()
					.getStatusCode());

			if (responseObject.getStatusCode() == StatusCodeConstants.STATUS_CODE_OK
					|| responseObject.getStatusCode() == StatusCodeConstants.STATUS_CODE_NOT_ACCEPTABLE) {
				HttpEntity entity = response.getEntity();
				if (entity != null)
					responseObject.setResponseString(EntityUtils.toString(
							entity, "UTF-8"));
			}

		} catch (ClientProtocolException e) {
			e.printStackTrace();
			responseObject.setResponseString(" ");
		} catch (UnknownHostException e) {
			e.printStackTrace();
			responseObject
					.setStatusCode(StatusCodeConstants.STATUS_CODE_UNKNOWN_HOST_EXCEPTION);
			responseObject.setResponseString(" ");
		} catch (HttpHostConnectException e) {
			e.printStackTrace();
			responseObject
					.setStatusCode(StatusCodeConstants.STATUS_CODE_HTTP_HOST_CONNECTION_EXCEPTION);
			responseObject.setResponseString(" ");
		} catch (IOException e) {
			e.printStackTrace();
			responseObject
					.setStatusCode(StatusCodeConstants.STATUS_CODE_IO_EXCEPTION);
			responseObject.setResponseString(" ");
		} catch (Exception e) {
			e.printStackTrace();
			responseObject
					.setStatusCode(StatusCodeConstants.STATUS_CODE_EXCEPTION);
			responseObject.setResponseString(e.getMessage());
		}
		// /log response
		Log.i("Response", responseObject.getResponseString());

		return responseObject;
	}

}



