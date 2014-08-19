package com.colors.supersaym.controller.tasks;

import java.util.ArrayList;

import org.json.JSONException;
import org.json.JSONObject;

import android.content.Context;

import com.colors.supersaym.controller.communication.Communication;
import com.colors.supersaym.controller.communication.RequestHeader;
import com.colors.supersaym.controller.communication.ResponseObject;
import com.colors.supersaym.controller.communication.Task;
import com.colors.supersaym.dataprovider.DataRequestor;
import com.colors.supersaym.storage.UIManager;
import com.facebook.Request;

public class MeScoreBoardTask extends Task {

	private String url;
	Context mxontext;
	private ResponseObject response;
	public static String CONTENT_TYPE_KEY = "Content-type";
	public static String ACCESS_TOKEN_KEY = "accessToken";
	public static String CONTENT_TYPE_VALUE = "application/x-www-form-urlencoded";

	public MeScoreBoardTask(DataRequestor requestor ,Context context, String fbID) {
		 setRequestor(requestor);
		setId(TaskID.ScoreTask);
		this.mxontext = context;
		url = Communication.Base_URL + "/score/format/json/userId/"+fbID;
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
			String sallySyamak = mainObject.getString("sallySyamak");
			String mosalslat = mainObject.getString("mosalslat");
			String manElQatel = mainObject.getString("manElQatel");
			UIManager.getInstance().setMmanElQatel(manElQatel);
			UIManager.getInstance().setmMosalslatScore(mosalslat);
			UIManager.getInstance().setmSallySyamakScore(sallySyamak);
			
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

	}

	@Override
	public Object getResult() {
		return response;
	}

	public ArrayList<RequestHeader> getHeadersList() {
		ArrayList<RequestHeader> headers = new ArrayList<RequestHeader>();
		RequestHeader header = new RequestHeader(CONTENT_TYPE_KEY,
				CONTENT_TYPE_VALUE);
		headers.add(header);

		return headers;
	}

}
