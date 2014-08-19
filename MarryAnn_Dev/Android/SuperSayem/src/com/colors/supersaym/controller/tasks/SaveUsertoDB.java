package com.colors.supersaym.controller.tasks;

import java.util.ArrayList;

import org.json.JSONException;
import org.json.JSONObject;

import android.content.Context;
import android.content.SharedPreferences;

import com.colors.supersaym.controller.communication.Communication;
import com.colors.supersaym.controller.communication.RequestHeader;
import com.colors.supersaym.controller.communication.ResponseObject;
import com.colors.supersaym.controller.communication.Task;
import com.colors.supersaym.dataprovider.DataRequestor;
import com.colors.supersaym.storage.Constants;
import com.colors.supersaym.storage.UIManager;

public class SaveUsertoDB extends Task {
	private String url;
	Context mxontext;
	private ResponseObject response;
	public static String CONTENT_TYPE_KEY = "Content-type";
	public static String ACCESS_TOKEN_KEY = "accessToken";
	public static String CONTENT_TYPE_VALUE = "application/x-www-form-urlencoded";
	private Object result;

	public SaveUsertoDB(DataRequestor requestor, Context context, String id,
			String name, String fristname, String lastName, String birthday,String email,String token) {
		setRequestor(requestor);
		setId(TaskID.SaveUserTask);
		email=email.replace("@", "%");
		this.mxontext = context;
		url = "http://hitseven.net/index.php?/api/h7fb/mobileAddMe/username/"
				+ name + "/firstname/" + fristname + "/lastname/" + lastName
				+ "/email/"+email+"/credit/0/"+"/birthday/"+birthday+"/fb_id/"+id+"/token/"+token+"/format/json";
	
		url = url.replaceAll("\\s+", "");
		
	}

	@Override
	public void execute() {
		response = (ResponseObject) Communication.getMethod(url,
				getHeadersList(), mxontext);

		System.out.println("url" + url);
		mapServerError(response.getStatusCode());
		String r = response.getResponseString();
		JSONObject mainObject;
		try {
			mainObject = new JSONObject(r);
			String accountId=mainObject.getString("accountId");
			SharedPreferences appPreferences=mxontext.getSharedPreferences(
					Constants.appPreferencesName, Context.MODE_PRIVATE);
			appPreferences.edit().putString(UIManager.accountId,accountId ).commit();
			result=accountId;
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}

	@Override
	public Object getResult() {
		return result;
	}

	public ArrayList<RequestHeader> getHeadersList() {
		ArrayList<RequestHeader> headers = new ArrayList<RequestHeader>();
		RequestHeader header = new RequestHeader(CONTENT_TYPE_KEY,
				CONTENT_TYPE_VALUE);
		headers.add(header);

		return headers;
	}

}
