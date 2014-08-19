package com.colors.supersaym.controller.tasks;

import java.util.ArrayList;

import org.json.JSONException;
import org.json.JSONObject;

import android.content.Context;
import android.util.Log;

import com.colors.supersaym.controller.communication.Communication;
import com.colors.supersaym.controller.communication.RequestHeader;
import com.colors.supersaym.controller.communication.ResponseObject;
import com.colors.supersaym.controller.communication.Task;
import com.colors.supersaym.dataobjects.UserData;
import com.colors.supersaym.dataprovider.DataRequestor;
import com.colors.supersaym.storage.UIManager;


public class AllScoreBoardTask extends Task {

	private String url;
	Context mxontext;
	private ResponseObject response;
	public static String CONTENT_TYPE_KEY = "Content-type";
	public static String ACCESS_TOKEN_KEY = "accessToken";
	public static String CONTENT_TYPE_VALUE = "application/x-www-form-urlencoded";
	ArrayList<UserData>scoreBoardArray;

	public AllScoreBoardTask(DataRequestor requestor ,Context context, String catId,String CategoryName,int start, int  size) {
		 setRequestor(requestor);
		setId(TaskID.AllScoreTask);
		scoreBoardArray=new ArrayList<UserData>();
		this.mxontext = context;
		http://gloryette.org/mobile/index.php?/api/hitcall/all_scoreboard/format/json/categoryId/1/categoryName/sallySyamak/start/0/size/10
		url = Communication.Base_URL + "/all_scoreboard/format/json/categoryId/"+catId+"/categoryName/"+CategoryName+"/start/"+start+"/size/"+size;

	

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
			int size = mainObject.getInt("size");
			for (int i = 0; i <size; i++) {
				JSONObject tempObject=mainObject.getJSONObject(i+"");
				UserData data = UserData.userFromJson(tempObject);
				scoreBoardArray.add(data);
			}
			Log.d("Shaimaa", "scoreBoardArray "+scoreBoardArray.size());

			UIManager.getInstance().setScoreBoardArray(scoreBoardArray);
			
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
